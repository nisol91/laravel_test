<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::latest()->paginate(10);
        return view('galleries.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
    }
}
