<?php

class VoltsController extends BaseController {

    public function scores()
    {
        $this->loggedUser = FacebookUtils::fb()->getUser();
        $this->activeUser = Input::get('fb_uid', $this->loggedUser);    
        
        $scores = Category::select('volt_scores.*','categories.*')
                          ->leftJoin('volt_scores','volt_scores.cat_id','=','categories.id')
                          ->where('fb_uid',$this->activeUser)
                          ->orWhereNull('fb_uid');
        
        //Add cat_id filter
        if(Input::has('cat_id'))
            $scores->where('id',Input::get('cat_id'));
        
        //Add order if there is order input set. If not it will check to sort it by category params later
        if(Input::has('order_by'))
            $scores->orderBy(Input::get('order_by'),Input::get('order_dir','asc'));
        
        //Add limit
        if(Input::has('limit'))
            $scores->skip(Input::get('offset',0))->take(Input::get('limit'));
        
        $this->displayData['scores'] = $scores->get();
        
        return View::make($this->theme.'.dynamic.volts.scores')->with($this->displayData);
    }
    
    
    public function history()
    {
        $this->loggedUser = FacebookUtils::fb()->getUser();
        $this->activeUser = Input::get('fb_uid', $this->loggedUser);  
        
        $volts = Volt::with(('category'))
                      ->where(function($query){

                          $query->where('from_uid',$this->activeUser)
                                ->orWhere('to_uid',$this->activeUser);
                          
                      });
        
        if(Input::has('limit'))
            $volts->skip(Input::get('offset',0))->take(Input::get('limit'));
        
        if(Input::has('cat_id'))
            $volts->where('cat_id',Input::get('cat_id'));
        
        $volts = $volts->orderBy('updated_at','desc')->get();
        
        //We want to make only one call to Facebook API to get the user details, so we need all ids in 1 array.
        $user_ids = array_unique(
                    array_merge(
                        array_fetch($volts->toArray(),'from_uid'),
                        array_fetch($volts->toArray(),'to_uid')
                    )
                 );
        
        //Running the fql query
        $fql = array(
            'method' => 'fql.query',
            'query' => 'SELECT id,name FROM profile WHERE id IN ('.implode(',', $user_ids).')'
        );
        $fql_resp = FacebookUtils::fb()->api($fql);
        
        //Creating the users array
        $users = array();
        foreach($fql_resp as $u)
            $users[$u['id']] = $u['name'];
        
        $this->displayData['volts'] = $volts;
        $this->displayData['users'] = $users;
        
        return View::make($this->theme.'.dynamic.volts.history')->with($this->displayData);
    }
    
    public function volt($toUid, $catId, $volt_val)
    {
        $this->loggedUser = FacebookUtils::fb()->getUser();
        $this->activeUser = Input::get('fb_uid', $this->loggedUser);
            
        
        //You cheater! You won't get to volt for yourself!
        if($this->activeUser == $toUid)
           return NULL;
        
        $hasVolted = Volt::where('from_uid', $this->activeUser)
                          ->where('to_uid', $toUid)
                          ->where('cat_id', $catId)->count();
        
        //You can't make your friends just volt for you 1000 times either
        if($hasVolted)
            return NULL;
        
        //Adding the volt to the history
        $volt = new Volt();
        $volt->from_uid = $this->activeUser;
        $volt->to_uid = $toUid;
        $volt->cat_id = $catId;
        $volt->volt = $volt_val;
        $volt->save();
        
        //Lets get the existing scores
        $scores = VoltScore::where('fb_uid', $toUid)
                           ->where(function($query) use ($catId) {
                               
                               $query->where('cat_id',1)
                                     ->orWhere('cat_id',$catId);
                               
                           })
                           ->get();
        
        //We might not have volts in the appropriate category ...
        $updateScores = array(1 => FALSE, $catId => FALSE);
        
        foreach($scores as $score)
        {
            $score->volts_count ++;
            $score->volts_score += $volt_val;
            $score->save();
            $updateScores[$score->cat_id] = TRUE;
        }
        
        //We don't need the collection lets convert it to array
        $scores = $scores->toArray();
        
        //... then we need to do inserts.
        foreach($updateScores as $cat_id => $check)
        {
            if($check) continue;
            
            $voltScore = new VoltScore();
            $voltScore->fb_uid = $toUid;
            $voltScore->cat_id = $cat_id;
            $voltScore->volts_count = 1;
            $voltScore->volts_score = $volt_val;
            $voltScore->save();
            
            //Lets add this category to scores
            $scores = array_merge($scores, array($voltScore->toArray()));
        }
        
        //And now for the achievements
        $achievements = Achievement::where(function($query) use ($scores) {
                                        
                                        //This does look kinda scary, but we just get the appropriate
                                        //category from the scores array ...
                                        $cat = array_first($scores,function($key,$value) {
                                           return $value['cat_id'] == 1;
                                        });
                                        
                                        //... calculate the average ...
                                        $avg = $cat['volts_score']/$cat['volts_count'];
                                        
                                        //.. and get all achievements from the NULL category wich are eligible
                                        $query->where('cat_id',1)
                                              ->where('volts_req', '<=', $cat['volts_count'])
                                              ->where('avg_req', '<=', $avg); 
                                   })
                                   //Same as the last one only we use the catId variable
                                   ->orWhere(function($query) use ($scores, $catId) {
                                       
                                        $cat = array_first($scores,function($key,$value) use ($catId) {
                                           return $value['cat_id'] == $catId;
                                        });
                                        
                                        $avg = $cat['volts_score']/$cat['volts_count'];
                                        
                                        $query->where('cat_id', $catId)
                                              ->where('volts_req', '<=', $cat['volts_count'])
                                              ->where('avg_req', '<=', $avg); 
                                   })
                                   ->get();
                                   
        //Syncing user with new achievements                          
        $user = User::find($toUid);
        $user->achievements()->sync(array_fetch($achievements->toArray(),'id'));
        
        return;
    }
}