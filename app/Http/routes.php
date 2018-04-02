<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
* Home
*/

Route::get('/', [
    'uses' => '\Greenbook\Http\Controllers\HomeController@index',
    'as' => 'home',
]);

/**
* Alert
*/

Route::get('/alert', function() {
    return redirect()->to('/')->with('info', 'You have signed up!');    
});

/**
* Authentication
*/

Route::get('/signup', [
    'uses' => '\Greenbook\Http\Controllers\AuthController@getSignup',
    'as' => 'auth.signup',
    'middleware' => ['guest'],
]);

Route::post('/signup', [
    'uses' => '\Greenbook\Http\Controllers\AuthController@postSignup',
    'middleware' => ['guest'],
]);

Route::get('/signin', [
    'uses' => '\Greenbook\Http\Controllers\AuthController@getSignin',
    'as' => 'auth.signin',
    'middleware' => ['guest'],
]);

Route::post('/signin', [
    'uses' => '\Greenbook\Http\Controllers\AuthController@postSignin',
    'middleware' => ['guest'],
]);

Route::get('/signout', [
    'uses' => '\Greenbook\Http\Controllers\AuthController@getSignout',
    'as' => 'auth.signout',
]);

/**
* Search
*/

Route::get('/search', [
    'uses' => '\Greenbook\Http\Controllers\SearchController@getResults',
    'as' => 'search.results',
]);

/**
* User profile
*/

Route::get('/user/{username}', [
    'uses' => '\Greenbook\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index',
]);

Route::get('/profile/edit', [
    'uses' => '\Greenbook\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
    'uses' => '\Greenbook\Http\Controllers\ProfileController@postEdit',
    'middleware' => ['auth'],
]);

/**
* Friends
*/

Route::get('/friends', [
    'uses' => '\Greenbook\Http\Controllers\FriendController@getIndex',
    'as' => 'friends.index',
    'middleware' => ['auth'],
]);

Route::get('/friends/add/{username}', [
    'uses' => '\Greenbook\Http\Controllers\FriendController@getAdd',
    'as' => 'friends.add',
    'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
    'uses' => '\Greenbook\Http\Controllers\FriendController@getAccept',
    'as' => 'friends.accept',
    'middleware' => ['auth'],
]);

/**
* Statuses
*/

Route::post('/status', [
    'uses' => '\Greenbook\Http\Controllers\StatusController@postStatus',
    'as' => 'status.post',
    'middleware' => ['auth'],
]);

Route::post('/status/{statusId}/reply', [
    'uses' => '\Greenbook\Http\Controllers\StatusController@postReply',
    'as' => 'status.reply',
    'middleware' => ['auth'],
]);
