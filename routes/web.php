<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

// Protected Admin Routes
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function(){
    
    // Admin Homepage
    Route::get('/', 'HomeController@index')->name('home');
    
    // Resource Post
    // TODO Add => Route::resource('posts', 'PostController');

    // Undefined Routes | 404
    Route::get('/{any?}', function () {
        abort('404');
    })->where('any','.*');
});


// Public Guest Routes
Route::get('/{any?}', function () {
    return view('guest.home');
})->where('any','.*');