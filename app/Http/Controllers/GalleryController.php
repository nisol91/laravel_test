<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::orderBy('id', 'DESC')->paginate(10);

        return view('galleries.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
    }


    public function showImages(Request $request, Album $album)
    {
        $images =  Photo::where('album_id', $album->id)->paginate(20);
        return view('galleries.images', ['images' => $images, 'title' => 'images', 'album' => $album]);
    }
}
