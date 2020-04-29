<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('post', 'PostController')->only([
    'index', 'show', 'create', 'store', 'edit', 'update'
]);

Route::resource('user', 'UserController')->only([
    'show', 'edit', 'update'
]);

Route::resource('grouprequest', 'GroupRequestController')->only([
    'index','create', 'store', 'show', 'update'
]);

Route::post('comment', 'PostController@storeComment')->name('comment.store');


//Axios stuff
Route::get('api/courseposts', 'HomeController@getPostsForCourse')->name('axios-home-posts');
Route::post('api/postposters', 'HomeController@getNamesForPost')->name('axios-home-names');