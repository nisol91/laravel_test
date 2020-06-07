<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlbumsController extends Controller
{
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
        $queryBuilder = DB::table('albums')->orderBy('id', 'desc');

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
        return view('albums.albums', ['albums' => $albums, 'title' => 'ALBUMS']);
    }

    public function delete($id)
    {
        /*
        $query = 'delete from albums WHERE id=:id';
        return DB::delete($query, ['id' => $id]);
        // return redirect()->back();
        // dd('eccolo-->' . $id);
        */

        //****************
        // metodo con il query builder di laravel
        $queryBuilder = DB::table('albums')->where('id', '=', $id)->delete();
        return $queryBuilder;
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
        $queryBuilder = DB::table('albums')->where('id', '=', $id)->get();
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
        $queryBuilder = DB::table('albums')->where('id', '=', $id)->get();
        $album = $queryBuilder;
        // dd($album);
        return view('albums.edit', ['title' => 'edit', 'id' => $id, 'album' => $album[0]]);
    }

    public function store($id, Request $request)
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
        $queryBuilder = DB::table('albums')->where('id', '=', $id)->update(
            [
                'album_name' => request()->input('name'),
                'description' => request()->input('description'),
            ]
        );
        $result = $queryBuilder;
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
        $id = 1;
        $queryBuilder = DB::table('albums')->insert(
            [
                'album_name' => request()->input('name'),
                'description' => request()->input('description'),
                'user_id' => $id
            ]
        );
        $result = $queryBuilder;

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
}
