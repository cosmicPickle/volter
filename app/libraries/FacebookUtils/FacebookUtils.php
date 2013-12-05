<?php namespace Volter\FacebookUtils;

class FacebookUtils {
    
        protected static $facebookAppId = '628095857231555';
        protected static $facebookAppSecret = '1de8f6bb6069e4055d5087c02597ad83';
        protected static $facebookCookie = true;
        protected static $fb;
        
        public function __construct()
        {
            self::$fb = new \Facebook(array(  
                           'appId'  => self::$facebookAppId,  
                           'secret' => self::$facebookAppSecret,  
                           'cookie' => self::$facebookCookie
                       ));
        }
        
        public function fb()
        {
            return self::$fb;
        }
}

