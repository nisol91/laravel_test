<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // se il nome della tabella non coincide con il nome della classe
    protected $table = 'albums';

    // se la primary key fosse diversa da 'id'
    // protected $primaryKey = 'album_id'


    // i campi che possono essere riempiti
    protected $fillable = ['album_name', 'description', 'user_id'];


    // questa helper function mi ritorna il corretto path interno per caricare le foto nel frontend
    public function getPathAttribute()
    {
        $url = $this->album_thumb;
        if (stristr($this->album_thumb, 'http') == false) {
            # code...
            $url = 'storage/' . $this->album_thumb;
        }
        return $url;
    }
}
