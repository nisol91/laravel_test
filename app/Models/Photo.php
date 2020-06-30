<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Album;


class Photo extends Model
{

    // questa helper function mi ritorna il corretto path interno per caricare le foto nel frontend
    // in pratica mi crea un path dell'oggetto photo che posso prendere cosi: asset($photo->path)
    // è utile quando si hanno sia path url che path storage
    // Funziona cosi: get + nome attributo + Attribute
    // il nome attributo, nel metodo è scritto camelcase, per andare a prenderlo nel frontend
    // invece è underscorecase: es ImgPath -> img_path
    // questi metodi si chiamano Accessors
    public function getPathAttribute()
    {
        $url = $this->img_path;
        if (stristr($this->img_path, 'http') == false) {
            $url = 'storage/' . $this->img_path;
        }
        return $url;
    }

    /* in alternativa si può modificare direttamente l'ImgPath */
    /* public function getImgPathAttribute($value)
    {
        if (stristr($value, 'http') == false) {
            $value = 'storage/' . $value;
        }
        return $value;
    } */

    /**
     * un altro helper utile è set
     * in questo caso Name è il field da db che voglio gestire/modificare,
     * e ovviamente in ingresso vuole il suo valore
     * in questo caso non c e return
     * Questi metodi si chiamano Mutators
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }


    /*
    * relazioni
    */
    public function album()
    {
        // album_id e id sarebbero sottointese ma le specifico comunque per completezza
        return $this->belongsTo(Album::class, 'album_id', 'id');

        //grazie a questa relazione, posso ritornare l'album legato a quella foto scrivendo
        // semplicemente $photo->album, posto che io abbia usato il type hinting (Photo $photo)
    }
}
