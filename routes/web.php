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

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');


Route::get('/admin','AdminController@index');
Route::get('/admin/users','AdminController@users');
Route::resource('/admin/tag', 'TagController',['except' => ['destroy']]);
Route::post('/admin/tag/delete','TagController@delete');
Route::post('/admin/tag/operate/{id}','TagController@operate');
Route::resource('/admin/question', 'QuestionController',['except' => ['destroy','create']]);
Route::get('admin/question/create/{qtype}','QuestionController@create');
Route::post('/admin/question/delete','QuestionController@delete');
Route::get('admin/comment','CommentController@index');

Route::get('/test', 'TestController@index');
Route::post('/test', 'TestController@prepare');
Route::post('/test/{test_id}/next/{id}', 'TestController@next');
Route::get('/test/{test_id}/judge', 'TestController@judge');
Route::get('/test/{test_id}/details', 'TestController@detail');
Route::get('/test/{test_id}/alldetails', 'TestController@allDetail');
Route::get('/test/{test_id}/{id}', 'TestController@show');

Route::get('/history','HistoryController@index');

Route::get('/contact','ContactController@index');
Route::get('/contact/message','ContactController@message');


Route::any('/weixin', 'WeixinController@index');
Route::get('/logout', 'Auth\LoginController@logout');


