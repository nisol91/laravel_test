<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use View;

class PageController extends Controller
{
    protected $data = [
        [
            'name' => 'Nicola',
            'lastname' => 'sazzo'
        ],
        [
            'name' => 'frederic',
            'lastname' => 'sazzo II'
        ],
        [
            'name' => 'max',
            'lastname' => 'sazzo senior'
        ],
    ];
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
    public function staff()
    {
        return view('staff_b', ['title' => 'Our staff', 'dataStaff' => $this->data]);
    }
}
