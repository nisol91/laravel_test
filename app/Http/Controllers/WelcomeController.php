<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome($name = '', $lastname = '', $age = 0, Request $req)
    {
        $language = $req->input('language');
        return 'hello -->' . $name . ' ' . $lastname . ' ' . 'age: ' . $age . ' language-->' . ' ' . $language;
    }
}
