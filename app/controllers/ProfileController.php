<?php

class ProfileController extends BaseController {
        
	public function index()
	{
            $this->uid = FacebookUtils::fb()->getUser();
            $ach = new Achievement();
            
            var_dump($ach->noUser($this->uid));
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