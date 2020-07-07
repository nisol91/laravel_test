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


// *******


// Route::get('/albums', 'AlbumsController@index')->name('allAlbums');
// Route::get('/albums/{id}/delete', 'AlbumsController@delete');
//bisogna sempre cautelarsi perchè l'id sia numerico, per evitare che una rotta tipo albums/create
// si confonda con albums/{id}
Route::get('/albums/{id}', 'AlbumsController@show')->where('id', '[0-9]+');
Route::patch('/albums/{id}', 'AlbumsController@store')->name('photos.store');

// Route::get('/albums/create', 'AlbumsController@creation')->name('createAlbum');
Route::get('/users-with-no-album', 'AlbumsController@usersNoAlbum');


//mi genera automaticamente tutte le rotte per Photos
Route::resource('photos', 'PhotosController');



//la rotta /albums/{id} è sempre la stessa, ma in base a se la chiamo dal frontend col DELETE o col GET o col PATCH
// mi va a chiamare un differente metodo del controller delete->delete, get->show, patch->store








Route::get('/users', function () {
    return User::all();
});

Route::get('/photos', function () {
    return Photo::all();
});

Auth::routes();

// qui dentro metto tutte le routes protette da middleware
Route::group(['middleware' => 'auth', 'prefix' => 'dashboard'], function () {
    Route::get('/albums/create', 'AlbumsController@creation')->name('createAlbum');
    Route::get('/albums', 'AlbumsController@index')->name('allAlbums');
    Route::get('/albums/{album}/images', 'AlbumsController@getImages')->name('albumImages')->where('id', '[0-9]+');
    Route::get('/albums/{id}/edit', 'AlbumsController@edit')->name('editAlbum');
    Route::delete('/albums/{id}', 'AlbumsController@delete')->name('deleteAlbum');
    Route::post('/albums', 'AlbumsController@saveNewAlbum')->name('saveNewAlbum');
});

Route::get('/home', 'HomeController@index')->name('homePage')->middleware('auth');
// Route::get('/home', 'HomeController@index');
