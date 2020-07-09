<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumCategory extends Model
{

    // è la tabella delle categorie
    protected $table = 'album_categories';


    /*
    * relazioni
    */
    public function albums()
    {
        //'album _category' è la tabella ponte
        return $this->belongsToMany(Album::class, 'album_category', 'category_id', 'album_id')->withTimestamps();
    }
}
