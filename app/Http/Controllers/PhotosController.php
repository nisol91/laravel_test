<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;


class PhotosController extends Controller
{
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

        // return $photo;
        return view('photos.edit', ['title' => 'edit photo', 'id' => $photo->id, 'photo' => $photo]);
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


        $photo->name = request()->input('name');
        $photo->description = request()->input('description');
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
        $fileName = $file->storeAs(env('IMG_DIR'), $string);

        $img_path = $fileName;
        $photo->img_path = $img_path;
        return true;
    }
}
