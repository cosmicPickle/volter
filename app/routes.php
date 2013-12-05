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
Route::get('profile',array("before" =>"fblogin", "uses" => "ProfileController@index"));
