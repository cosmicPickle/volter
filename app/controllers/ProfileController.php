<?php

class ProfileController extends BaseController {
        
        protected $layout = "profile_template";
        protected $activeUser;
        protected $loggedUser;
        protected $displayData = array();
        
        public function __construct() {
            
            $this->layout = $this->theme.".".$this->layout;
            
            $this->displayData = array(
                "achvPerLine" => 5,
                "achvPerLineReduced" => 3,
                "achvLinesPerLoad" => 3,
                "voltsPerLine" => 3,
                "voltsLinesPerLoad" => 3,
                "voltsHistoryPerLoad" => 10,
                "activeUser" => & $this->activeUser,
                "loggedUser" => & $this->loggedUser
            ); 
            
        }
	public function index($action = 'profile', $fbUid = NULL)
	{
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $this->activeUser = $fbUid ? $fbUid : $this->loggedUser;
            $this->layout->with($this->displayData);
            
            $method = "_".$action;
            
            if(method_exists($this, $method))
               $this->{$method}();
            
            if(View::exists($this->theme.'.static.'.$action))
                $this->layout->content = View::make($this->theme.'.static.'.$action)->with($this->displayData);
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