<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumCreationRequest;
use App\Http\Requests\AlbumEditRequest;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{

    public function __construct()
    {

        /* alternativamente a dichiararlo nelle routes (web, api), posso dire nel costruttore di mettermi sotto
        middleware certe routes
        */
        // $this->middleware('auth')->only(['create', 'edit']);
        // $this->middleware('auth')->except(['index']);

    }
    public function index(Request $request)
    {

        //****************
        // ***metodo con la classe Album
        // return Album::all();

        // ***metodo usando la query grezza e la facade DB
        // $query = 'select * from albums';
        // return DB::select($query);

        //****************
        // ***metodo con la request (sarebbe la query string dell url)

        // $query = 'select * from albums';

        // $query .= ' WHERE 1=1';

        // if ($request->has('id')) {

        //     $query .= 'AND where id =' . (int) $request->get('id');
        // }
        // if ($request->has('album_name')) {

        //     $query .= " AND album_name =" . $request->get('album_name');
        // }

        // dd($query);
        // return DB::select($query);

        //****************
        // ***metodo con la request per evitare sql injection
        // +++ con questo metodo si possono effettuare query grezze complesse

        /*
        $query = 'select * from albums WHERE 1=1';

        $params = [];

        if ($request->has('id')) {

            $params['id'] = $request->get('id');
            $query .= " AND id=:id";
        }
        if ($request->has('album_name')) {
            $params['album_name'] = $request->get('album_name');
            $query .= " AND album_name=:album_name";
        }

        $query .= ' ORDER BY id desc';

        // dd($query);
        $albums = DB::select($query, $params);
        return view('albums.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
        */




        //****************
        // metodo con il query builder di laravel
        // $queryBuilder = Album::orderBy('id', 'desc'); -->> senza usare il Model di Eloquent
        $queryBuilder = Album::orderBy('id', 'desc')->withCount('photos');
        // NB il primo metodo che si chiama deve sempre essere STATICO (::), poi uso la freccia ->

        // filtro solo gli album dell utente
        $queryBuilder->where('user_id', Auth::user()->id);
        //in alternativa per accedere ai dati dlel utente:
        // $request->user()


        // ?id=12 (per avere filtri per id)
        if ($request->has('id')) {
            $queryBuilder->where('id', '=', $request->input('id'));
        }
        // ?album_name=12 (per avere filtri per album_name)
        if ($request->has('album_name')) {
            $queryBuilder->where('album_name', 'like', '%' . $request->input('album_name') . '%');
        }
        // col get ritorno sempre la collection, e lo faccio dopo aver filtrato
        $albums = $queryBuilder->get();
        // dd($albums);
        return view('albums.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
    }

    public function delete(Album $id)
    {
        /*
        $query = 'delete from albums WHERE id=:id';
        return DB::delete($query, ['id' => $id]);
        // return redirect()->back();
        // dd('eccolo-->' . $id);
        */

        //****************
        // metodo con il query builder di laravel
        // $queryBuilder = Album::where('id', '=', $id)->delete();
        // return $queryBuilder;


        //****************
        // in alternativa
        // $album = Album::findOrFail($id);
        // $res = $album->delete();


        //****************
        // in alternativa inietto l'album e lo cerco per primary key nella funzione
        // esso deve coincidere col nome dato al parametro nella route web, in questo caso {id}
        $album = $id;
        $thumbnail = $album->album_thumb;
        $disk = config('filesystems.default');

        $res = $album->delete();
        //elimino anche la thumbnail
        if ($res) {
            if ($thumbnail && Storage::disk($disk)->exists($thumbnail)) {
                Storage::disk($disk)->delete($thumbnail);
            }
        }


        return $res;
    }

    public function show($id)
    {
        /*
        $query = 'select * from albums WHERE id=:id';
        return DB::select($query, ['id' => $id]);
        // return redirect()->back();
        // dd('eccolo-->' . $id);

        */

        //****************
        // metodo con il query builder di laravel
        $queryBuilder = Album::where('id', '=', $id)->get();
        return $queryBuilder;
    }

    public function edit($id)
    {
        /*
        $query = 'select album_name, description, id from albums WHERE id=:id';
        $album = DB::select($query, ['id' => $id]);
        return view('albums.edit', ['title' => 'edit', 'id' => $id, 'album' => $album[0]]);
        */

        //****************
        // metodo con il query builder di laravel
        $queryBuilder = Album::where('id', '=', $id)->get();
        $album = $queryBuilder;
        // dd($album);
        return view('albums.edit', ['title' => 'edit', 'id' => $id, 'album' => $album[0]]);
    }


    // salva i dati per EDIT
    public function store($id, AlbumEditRequest $request)
    {
        /*
        // dd(request()->all());
        $data = request()->only([
            'name',
            'description'
        ]);
        $data['id'] = $id;
        // dd($data);
        $query = "UPDATE albums SET album_name=:name, description=:description";
        $query .= " WHERE id=:id";
        $result = DB::update($query, $data);
        */


        //****************
        // metodo con il query builder di laravel







        // $queryBuilder = Album::where('id', '=', $id)->update(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'album_thumb' => $album_thumb,

        //     ]
        // );
        // $result = $queryBuilder;


        // in alternativa trovo l'oggetto album e lo modifico cosi

        $album = Album::find($id);
        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $album->user_id = $request->user()->id;

        //per il caricamento di files
        $album_thumb = $this->processFile($request, $id, $album);
        $result = $album->save();


        $message = $result ? 'ooottimo, album con id: ' . $id . ' aggiornato' : 'non aggiornato :(';
        session()->flash('message', $message);
        return redirect()->route('allAlbums');
        // dd($query);
    }

    public function creation()
    {
        //per sicurezza istanzio un album vuoto all'inizio
        // cosi se nel frontend ci sono variabili $album, posso
        $album = new Album();
        return view('albums.create', ['title' => 'create new album', 'album' => $album]);
    }

    //AlbumRequest è la http request del form di salvataggio, mi basta iniettarla (type hinting) nel metodo, non serve altro
    public function saveNewAlbum(AlbumCreationRequest $request)
    {
        /*
        // dd(request()->all());
        $data = request()->only([
            'name',
            'description'
        ]);
        //per ora hardcodiamo l'userid
        $id = 1;
        $data['user_id'] = $id;
        $query = "INSERT INTO albums (album_name, description, user_id)";
        $query .= " VALUES(:name, :description, :user_id)";
        $result = DB::insert($query, $data);


        */
        //****************
        // metodo con il query builder di laravel
        $id = $request->user()->id;


        // $queryBuilder = Album::insert(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => $id
        //     ]
        // );




        /*
        create è molto piu potente di insert, mi permette di decidere quali sono i campi
        fillable, ovvero decidere quali sono quelli protetti e appunto fillabili, e quelli no (lo decido nel model)
        */
        // $queryBuilder = Album::create(
        //     [
        //         'album_name' => request()->input('name'),
        //         'description' => request()->input('description'),
        //         'user_id' => $id
        //     ]
        // );

        // $result = $queryBuilder;

        //altro metodo alternativo : istanzio un nuovo oggetto Album
        $album = new Album();
        $album->album_name = request()->input('name');
        $album->description = request()->input('description');
        $album->user_id = $id;
        $album->album_thumb = '';
        $result = $album->save();
        //dd($result);
        //per il caricamento di files
        if ($result) {
            $fileProcessed = $this->processFile(request(), $album->id, $album);
            if ($fileProcessed) {
                $result = $album->save();
            }
        }


        $message = $result ? 'ooottimo, album con id: ' . $id . ' e nome ' . request()->input('name') . ' creato' : 'non aggiornato :(';

        //salvo in sessione il messaggio
        session()->flash('message', $message);

        //redirect a tutti gli album
        return redirect()->route('allAlbums');
    }

    public function usersNoAlbum()
    {
        // con una join unisco i fields di due tabelle
        $usersNoAlbum = DB::table('users as u')->leftJoin('albums as a', 'u.id', '=', 'a.user_id')
            ->select('u.id', 'email', 'name', 'album_name')
            ->whereNull('album_name')
            //cosi posso inserire una query raw
            // ->whereRaw('album_name is null')
            ->get();
        return $usersNoAlbum;
    }


    // due alternative per prendere le immagini, o vado per id semplice, o inietto l'album
    // se inietto l'album, nell'url in web routes deve esserci {album} e non {id}

    /* public function getImages($id)
    {

        $images = Photo::where('album_id', $id)->get();
        // dd($images);
        return $images;
    } */
    public function getImages(Album $album)
    {

        // $images = Photo::where('album_id', $album->id)->latest()->get();
        $images = Photo::where('album_id', $album->id)->paginate(env('IMG_PER_PAGE'));

        // dd($images);
        // return $images;
        return view('photos.albumimages', ['images' => $images, 'title' => 'IMAGES', 'album' => $album]);
    }

    /**
     * this method processes files upload
     */
    public function processFile($request, $id, &$album): bool
    {

        $album_thumb = '';
        // nb posso usare indifferentemente request() o la variabile iniettata che ho chiamato $request
        $file = $request->file('album_thumb');

        if (!$request->hasFile('album_thumb') || !$file->isValid()) {
            return false;
        }
        //nome standard dato da laravel
        // $fileName = $file->store(env('ALBUM_THUMBS_DIR'));

        //nome custom
        $string = $id . '.' . $file->extension();
        $fileName = $file->storeAs(env('ALBUM_THUMBS_DIR'), $string);

        $album_thumb = $fileName;
        $album->album_thumb = $album_thumb;
        return true;
    }
}
