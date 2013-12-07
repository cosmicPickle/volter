<?php

class HomeController extends BaseController {
        
        protected $layout = "layouts.default.template";
        
	public function index()
	{
            if(!FacebookUtils::fb()->getUser())
                $this->layout->content = View::make("layouts.default.guest");
            else
                $this->layout->content = View::make("layouts.default.member");
            
	}

}