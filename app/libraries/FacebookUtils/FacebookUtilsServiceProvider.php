<?php namespace Volter\FacebookUtils;

use Illuminate\Support\ServiceProvider;

class FacebookUtilsServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('facebook_utils', function()
        {
            return new FacebookUtils;
        });
    }

}