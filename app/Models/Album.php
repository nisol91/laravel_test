<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // se il nome della tabella non coincide con il nome della classe
    protected $table = 'Albums';

    // se la primary key fosse diversa da 'id'
    // protected $primaryKey = 'album_id'
}
