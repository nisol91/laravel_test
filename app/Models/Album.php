<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;
use App\User;

class Album extends Model
{
    // se il nome della tabella non coincide con il nome della classe
    protected $table = 'albums';

    // se la primary key fosse diversa da 'id'
    // protected $primaryKey = 'album_id'


    // i campi che possono essere riempiti
    protected $fillable = ['album_name', 'description', 'user_id'];


    // questa helper function mi ritorna il corretto path interno per caricare le foto nel frontend
    // in pratica mi crea un path dell'oggetto album che posso prendere cosi: asset($album->path)
    // è utile quando si hanno sia path url che path storage
    public function getPathAttribute()
    {
        $url = $this->album_thumb;
        if (stristr($url, 'http') == false) {
            $url = 'storage/' . $this->album_thumb;
        }
        return $url;
    }



    /*
    * relazioni
    */

    public function photos()
    {
        return $this->hasMany(Photo::class, 'album_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
