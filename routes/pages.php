<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pages Routes
|--------------------------------------------------------------------------
|

|
*/

Route::get('/about', 'PageController@about');
Route::get('/blog', 'PageController@blog');
