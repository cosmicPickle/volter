<?php

class ProfileController extends BaseController {
        
        protected $layout = "profile_template";
        
        public function __construct() {
            
            parent::__construct();
            $this->layout = $this->theme.".".$this->layout;
            
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
            $this->loggedUser = FacebookUtils::fb()->getUser();
            $userExists = User::where("fb_uid","=",$this->loggedUser)->count();

            if(!$userExists)
            {
                $user = new User();
                $user->fb_uid = $this->loggedUser;
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