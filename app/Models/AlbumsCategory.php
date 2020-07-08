<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumsCategory extends Model
{

    // è la tabella PIVOT delle categorie e degli album
    protected $table = 'album_category';
}
