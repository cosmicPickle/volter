<?php

class AchievementsController extends BaseController {
        
	public function all()
	{
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $this->activeUser = Input::get('fb_uid', $this->loggedUser);
            
            //Generating the achievements as separated in categories
            $achievements = Category::with(array('achievements' => function($query) { 
                
                //Do we have to limit the resulting achievements
                if(Input::has('limit'))
                {
                    $take = Input::get('limit');
                    $skip = Input::get('offset',0);
                    $query->skip($skip)->take($take);
                }      
                
                return $query;
                
            }, 'achievements.users' => function($query){
                $query->where('users.fb_uid',$this->activeUser);
            }));
            
            //If we have a cat_id filter we want to select achievements from a certain category only
            if(Input::has('cat_id'))
                $achievements->where('id', Input::get('cat_id'));

            $this->displayData['achievements'] = $achievements->get();
            //returning the rendered collection in json
            return View::make($this->theme.'.dynamic.achievements.all')->with($this->displayData);
	}
        
        public function records()
        {
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $this->activeUser = Input::get('fb_uid', $this->loggedUser);
            
            $user = User::with(array('achievements' => function($query){
                
                //Do we have category filter
                if(Input::has('cat_id'))
                    $query->where('cat_id', Input::get('cat_id'));
                
                //Do we have a limit
                if(Input::has('limit'))
                {
                    $take = Input::get('limit');
                    $skip = Input::get('offset',0);
                    $query->skip($skip)->take($take);
                }      
                
                return $query;
                
            }, 'achievements.category'))->findOrFail($this->activeUser);
            
            $user->achievements = $user->achievements->sortBy(function($achievement){ 
                return $achievement->category->name;
            });
            
            $this->displayData['user'] = $user;
            return View::make($this->theme.'.dynamic.achievements.records')->with($this->displayData);
        }
        
        public function notRecords()
        {
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $this->activeUser = Input::get('fb_uid', $this->loggedUser);
            
            $ach = new Achievement();
             
            $ach = $ach->noUser($this->activeUser);
            
            $this->displayData['achievements'] = $ach;
            return View::make($this->theme.'.dynamic.achievements.not_records')->with($this->displayData);
        }
}