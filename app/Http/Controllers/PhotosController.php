<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Album;
use Illuminate\Support\Facades\Storage;


class PhotosController extends Controller
{

    // regole per la validazione
    protected $rules = [
        // deve esistere nella tabella album e colonna id
        'album_id' => 'required|numeric|exists:albums,id',
        // deve essere unico nella tabella foto e colonna name
        'name' => 'required|unique:photos,name',
        'description' => 'required',
        'img_path' => 'required|image',
    ];

    protected $errorMessages = [
        'album_id.required' => 'il campo album è obbligatorio',
        'name.required' => 'il campo name è obbligatorio'

    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        $album_id = $req->input('album');
        $album = Album::findOrFail($album_id);
        $albums = $this->getAlbums();
        $photo = new Photo();
        return view('photos.create', ['title' => 'create new image', 'photo' => $photo, 'album' => $album, 'albums' => $albums]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            $this->rules,
            $this->errorMessages
        );
        $photo = new Photo();
        $photo->name = request()->input('name');
        $photo->description = request()->input('description');
        $photo->album_id = request()->input('album_id');
        $photo->img_path = '';
        $result = $photo->save();
        //dd($result);
        //per il caricamento di files
        if ($result) {
            $fileProcessed = $this->processFile(request(), $photo->id, $photo);
            if ($fileProcessed) {
                $result = $photo->save();
            }
        }


        $message = $result ? 'ooottimo, foto con id: ' . $photo->id . ' e nome ' . request()->input('name') . ' creata' : 'qualcosa è andato storto :(';

        //salvo in sessione il messaggio
        session()->flash('message', $message);

        //redirect a tutti gli album
        return redirect("/albums/{$photo->album_id}/images");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        $albums = $this->getAlbums();
        $album = $photo->album;
        // return $photo;
        return view('photos.edit', ['title' => 'edit photo', 'id' => $photo->id, 'photo' => $photo, 'albums' => $albums, 'album' => $album]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        // dd($request);
        // dd(request()->only(['name', 'description']));
        // return $photo;


        $this->validate(
            $request,
            $this->rules,
            $this->errorMessages
        );

        $photo->name = request()->input('name');
        $photo->description = request()->input('description');
        $photo->album_id = request()->input('album_id');

        //per il caricamento di files
        $img_path = $this->processFile($request, $photo->id, $photo);
        $result = $photo->save();


        $message = $result ? 'ooottimo, foto con id: ' . $photo->id . ' aggiornata' : 'foto non aggiornata :(';
        session()->flash('message', $message);
        return redirect("/albums/{$photo->album_id}/images");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        // Photo::findOrFail($id)->destroy();
        // return Photo::destroy($id);

        $res = $photo->delete();

        // elimino anche dallo storage, oltre che dal db
        $disk = config('filesystems.default');
        $path = $photo->img_path;
        if ($res) {
            if ($path && Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        }


        return '' . $res;
    }


    /**
     * this method processes files upload
     */
    public function processFile($request, $id, &$photo): bool
    {

        $img_path = '';
        // nb posso usare indifferentemente request() o la variabile iniettata che ho chiamato $request
        $file = $request->file('img_path');

        if (!$request->hasFile('img_path') || !$file->isValid()) {
            return false;
        }
        //nome standard dato da laravel
        // $fileName = $file->store(env('ALBUM_THUMBS_DIR'));

        //nome custom
        $string = $id . '.' . $file->extension();

        // uso il metodo getPathAttribute nel model (come ho fatto per album)
        $fileName = $file->storeAs(env('IMG_DIR') . '/' . $photo->album_id, $string);

        $img_path = $fileName;
        $photo->img_path = $img_path;
        return true;
    }

    public function getAlbums()
    {
        $albums = Album::orderBy('album_name')->get();
        return $albums;
    }
}
