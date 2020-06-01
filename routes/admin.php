<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|

|
*/

Route::get('/', function () {
    return 'admin home';
});
Route::get('/dashboard', function () {
    return 'admin dashboard';
});
