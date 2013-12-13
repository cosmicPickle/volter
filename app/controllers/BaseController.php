<?php

class BaseController extends Controller {

        protected $theme = "layouts.default";
        protected $activeUser;
        protected $loggedUser;
        protected $displayData = array();
        
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
        public function __construct() {
            
            $this->displayData = array(
                "achvPerLoadReduced" => 5,
                "achvPerLoad" => 15,
                "voltsPerLoad" => 15,
                "voltsHistoryPerLoad" => 10,
                "activeUser" => & $this->activeUser,
                "loggedUser" => & $this->loggedUser
            );
        }
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}