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

        // dd($query);
        return DB::select($query, $params);
    }
}
