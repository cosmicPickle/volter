<?php namespace Volter\FacebookUtils;

use Illuminate\Support\Facades\Facade;

class FacebookUtilsFacade extends Facade {

    protected static function getFacadeAccessor() { return 'facebook_utils'; }

}