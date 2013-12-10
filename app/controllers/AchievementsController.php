<?php

class AchievementsController extends BaseController {
        
	public function all()
	{
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
                $query->where('users.fb_uid',Input::get('fb_uid', FacebookUtils::fb()->getUser()));
            }));
            
            //If we have a cat_id filter we want to select achievements from a certain category only
            if(Input::has('cat_id'))
                $achievements->where('id', Input::get('cat_id'));

            $achievements = $achievements->get();
            
            //returning the rendered collection in json
            return View::make($this->theme.'.dynamic.achievements.all')->with(array('achievements' => $achievements));
	}
        
        public function records()
        {
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
                
            }, 'achievements.category'))->findOrFail(Input::get('fb_uid', FacebookUtils::fb()->getUser()));
            
            $user->achievements = $user->achievements->sortBy(function($achievement){ 
                return $achievement->category->name;
            });
            
            return View::make($this->theme.'.dynamic.achievements.records')->with(array('user' => $user));
        }
        
        public function notRecords()
        {
             $ach = new Achievement();
             
             $ach = $ach->noUser(Input::get('fb_uid', FacebookUtils::fb()->getUser()));
             
             return View::make($this->theme.'.dynamic.achievements.not_records')->with(array('achievements' => $ach));;
        }
}