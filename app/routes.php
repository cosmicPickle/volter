<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/



Route::get('/','HomeController@index');

//Authentications routes (login, logout)
Route::get('login', array("before" =>"fblogin", "as" => "login", "uses" => "ProfileController@login"));
Route::get('logout', array("before" =>"fblogin", "as" => "logout", "uses" => "ProfileController@logout"));

//Main profile route
Route::get('/{action}/{fb_uid?}',array("before" =>"fblogin", "uses" => "ProfileController@index"))
     ->where(array('action' => '(profile|achievements|volts|history)','fb_uid' => '[0-9]+'));

//Achievement routes
Route::any('achievements/all',array("before" =>"fblogin", "uses" => "AchievementsController@all"));
Route::any('achievements/records', array("before" => "fblogin", "uses" => "AchievementsController@records"));
Route::any('achievements/not_records', array("before" => "fblogin", "uses" => "AchievementsController@notRecords"));

//Volts routes
Route::any('volts/scores',array("before" =>"fblogin", "uses" => "VoltsController@scores"));
Route::any('volts/history',array("before" =>"fblogin", "uses" => "VoltsController@history"));
Route::any('volts/volt/{toUid}/{catId}/{volt}',array("before" =>"fblogin", "uses" => "VoltsController@volt"));