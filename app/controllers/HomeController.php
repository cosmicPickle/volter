<?php

class HomeController extends BaseController {
        
        protected $layout = "layouts.default.template";
        
	public function index()
	{
            if(!FacebookUtils::fb()->getUser())
                $this->layout->authArea = View::make("layouts.default.guest");
            else
                $this->layout->authArea = View::make("layouts.default.member");
            
	}

}