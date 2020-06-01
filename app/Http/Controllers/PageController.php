<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

class PageController extends Controller
{
    public function about()
    {
        return view('about');

        //altri possibili metodi
        // return view('about');
        // return app('view')->make('about');
    }

    public function blog()
    {
        return view('blog');
    }
}
