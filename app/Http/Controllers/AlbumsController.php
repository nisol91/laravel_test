<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
    public function index(Request $request)
    {

        // ***metodo con la classe Album
        // return Album::all();

        // ***metodo usando la query grezza e la facade DB
        // $query = 'select * from albums';
        // return DB::select($query);


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

        // ***metodo con la request per evitare sql injection
        // +++ con questo metodo si possono effettuare query grezze complesse

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
    }

    public function delete($id)
    {
        $query = 'delete from albums WHERE id=:id';
        return DB::delete($query, ['id' => $id]);
        // return redirect()->back();
        // dd('eccolo-->' . $id);
    }

    public function show($id)
    {
        $query = 'select * from albums WHERE id=:id';
        return DB::select($query, ['id' => $id]);
        // return redirect()->back();
        // dd('eccolo-->' . $id);
    }

    public function edit($id)
    {
        $query = 'select album_name, description, id from albums WHERE id=:id';
        $album = DB::select($query, ['id' => $id]);
        return view('albums.edit', ['title' => 'edit', 'id' => $id, 'album' => $album[0]]);
    }

    public function store($id, Request $request)
    {
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
        $message = $result ? 'ooottimo, album con id: ' . $id . ' aggiornato' : 'non aggiornato :(';
        session()->flash('message', $message);
        return redirect()->route('allAlbums');
        // dd($query);
    }

    public function creation()
    {
        return view('albums.create', ['title' => 'create new album']);
    }

    public function saveNewAlbum()
    {
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


        $message = $result ? 'ooottimo, album con id: ' . $id . ' e nome ' . $data['name'] . ' creato' : 'non aggiornato :(';

        //salvo in sessione il messaggio
        session()->flash('message', $message);

        //redirect a tutti gli album
        return redirect()->route('allAlbums');
    }
}
