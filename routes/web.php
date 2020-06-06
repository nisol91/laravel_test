<?php

use App\Http\Controllers\AlbumsController;
use App\Models\Album;
use App\Models\Photo;
use App\User;
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
    return view('welcome');
});


Route::get('/controller', 'HomeController@index');

Route::get('/test', function () {
    return view('components/test');
});
Route::get('/array', function () {
    return ['ab', 'cd'];
});
Route::get('/nome/{name?}/{lastname?}/{age?}', function ($name = '', $lastname = '', $age = 0) {
    return 'hello -->' . $name . ' ' . $lastname . ' ' . 'age: ' . $age;
})->where([
    'name' => '[a-zA-Z]+', 'lastname' => '[a-zA-Z]+', 'age' => '[0-9]{0,3}',
]);
Route::get('/welcomeController', 'WelcomeController@welcome');


Route::get('/albums', 'AlbumsController@index');
Route::get('/albums/{id}/delete', 'AlbumsController@delete');


Route::get('/users', function () {
    return User::all();
});

Route::get('/photos', function () {
    return Photo::all();
});
