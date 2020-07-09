<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        //  posso caricare, con l' eagerloading, tutte le categorie
        // legate a quell'album, questo perchè c'è una relazione
        // questo è molto importante ai fini dell'ottimizzazione del sito, poichè mi fa
        // un unica query per le categorie, invece che fare una query per ogni album
        $albums = Album::orderBy('id', 'DESC')->with('categories')->paginate(10);

        return view('galleries.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
    }


    public function showImages(Request $request, Album $album)
    {
        $images =  Photo::where('album_id', $album->id)->paginate(20);
        return view('galleries.images', ['images' => $images, 'title' => 'images', 'album' => $album]);
    }

    public function showAlbumsByCategory(AlbumCategory $category)
    {
        // questo equivale a $category->albums
        // ho preferito richiamare il metodo completo della relazione
        // per potergli dare il paginate
        $albums = $category->albums()->paginate(10);
        return view('galleries.albums', ['title' => 'albums for category: ' . $category->category_name, 'albums' => $albums]);
    }
}
