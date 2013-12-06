<?php

class VoltsController extends BaseController {

    public function scores()
    {
        $fbUid = Input::get('fb_uid', FacebookUtils::fb()->getUser());
        $scores = VoltScore::where('fb_uid',$fbUid);
        
        if(Input::has('cat_id'))
        {
            $catId = Input::get('cat_id') == 0 ? NULL : Input::get('cat_id'); 
            $scores->where('cat_id',$catId);
        }

        if(Input::has('avg'))
            $scores->whereRaw('volts_score/volts_count >= ?',array(Input::get('avg')));
        
        if(Input::has('limit'))
            $scores->skip(Input::get('offset',0))->take(Input::get('limit'));
        
        $scores = $scores->with('category')->get();
        
        $scores = $scores->sortBy(function($score){ 
                if(isset($score->category->name))
                    return $score->category->name;
        });
            
        echo json_encode($scores->toArray());
    }
    
    
    public function history()
    {
        $volts = Volt::with(('category'))
                      ->where(function($query){
                          
                          $fbUid = Input::get('fb_uid', FacebookUtils::fb()->getUser());
                          $query->where('from_uid',$fbUid)
                                ->orWhere('to_uid',$fbUid);
                          
                      });
        
        if(Input::has('limit'))
            $volts->skip(Input::get('offset',0))->take(Input::get('limit'));
        
        if(Input::has('cat_id'))
            $volts->where('cat_id',$cat_id);
        
        $volts = $volts->orderBy('updated_at','desc')->get();
        
        echo json_encode($volts->toArray());
    }
    
    public function volt($toUid, $catId, $volt_val)
    {
        $fromUid = Input::get('from_uid', FacebookUtils::fb()->getUser());
        
        //You cheater! You won't get to volt for yourself!
        //if($fromUid == $toUid)
        //   return NULL;
        
        $hasVolted = Volt::where('from_uid', $fromUid)
                          ->where('to_uid', $toUid)
                          ->where('cat_id', $catId)->count();
        
        //You can't make your friends just volt for you 1000 times either
        //if($hasVolted)
        //    return NULL;
        
        //Adding the volt to the history
        $volt = new Volt();
        $volt->from_uid = $fromUid;
        $volt->to_uid = $toUid;
        $volt->cat_id = $catId;
        $volt->volt = $volt_val;
        $volt->save();
        
        //Lets get the existing scores
        $scores = VoltScore::where('fb_uid', $toUid)
                           ->where(function($query) use ($catId) {
                               
                               $query->whereNull('cat_id')
                                     ->orWhere('cat_id',$catId);
                               
                           })
                           ->get();
        
        //We might not have volts in the appropriate category ...
        $updateScores = array(0 => FALSE, $catId => FALSE);
        
        foreach($scores as $score)
        {
            $score->volts_count ++;
            $score->volts_score += $volt_val;
            $score->save();
            $updateScores[($score->cat_id) ? $score->cat_id : 0] = TRUE;
        }
        
        //We don't need the collection lets convert it to array
        $scores = $scores->toArray();
        
        //... then we need to do inserts.
        foreach($updateScores as $cat_id => $check)
        {
            if($check) continue;
            
            $voltScore = new VoltScore();
            $voltScore->fb_uid = $toUid;
            $voltScore->cat_id = ($cat_id) ? $cat_id : NULL;
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
                                           return $value['cat_id'] == NULL;
                                        });
                                        
                                        //... calculate the average ...
                                        $avg = $cat['volts_score']/$cat['volts_count'];
                                        
                                        //.. and get all achievements from the NULL category wich are eligible
                                        $query->whereNull('cat_id')
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
        
        return 1;
    }
}