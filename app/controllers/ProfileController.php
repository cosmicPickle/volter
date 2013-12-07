<?php

class ProfileController extends BaseController {
        
        protected $layout = "layouts.default.template";
        protected $activeUser;
        protected $loggedUser;
        protected $displayData = array();
        
        public function __construct() {
            $this->displayData = array(
                "achvPerLine" => 5,
                "achvPerLineReduced" => 3,
                "achvLinesPerLoad" => 3,
                "voltsPerLine" => 3,
                "voltsLinesPerLoad" => 3,
                "activeUser" => & $this->activeUser,
                "loggedUser" => & $this->loggedUser
            ); 
        }
	public function index($fbUid = NULL)
	{
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $this->activeUser = $fbUid ? $fbUid : $this->loggedUser;
            
            //$this->displayData['activeUser'] = $this->activeUser;
            //$this->displayData['loggedUser'] = $this->loggedUser;
            
            $this->layout->content = View::make('layouts.default.profile')->with($this->displayData);
            
	}
        
        public function login()
        {
            $this->uid = FacebookUtils::fb()->getUser();
            $userExists = User::where("fb_uid","=",$this->uid)->count();

            if(!$userExists)
            {
                $user = new User();
                $user->fb_uid = $this->uid;
                $user->save();
            }
            
            return Redirect::to('profile');
        }
        
        public function logout()
        {
            FacebookUtils::fb()->destroySession();
            return Redirect::to('/');
        }
        
}