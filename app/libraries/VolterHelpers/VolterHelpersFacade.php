<?php namespace Volter\VolterHelpers;

use Illuminate\Support\Facades\Facade;

class VolterHelpersFacade extends Facade {

    protected static function getFacadeAccessor() { return 'volter_helpers'; }

}