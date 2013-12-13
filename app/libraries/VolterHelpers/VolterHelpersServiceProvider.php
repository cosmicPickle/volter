<?php namespace Volter\VolterHelpers;

use Illuminate\Support\ServiceProvider;

class VolterHelpersServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('volter_helpers', function()
        {
            return new VolterHelpers;
        });
    }

}