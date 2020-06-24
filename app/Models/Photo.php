<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{

    // questa helper function mi ritorna il corretto path interno per caricare le foto nel frontend
    // in pratica mi crea un path dell'oggetto photo che posso prendere cosi: asset($photo->path)
    // è utile quando si hanno sia path url che path storage
    public function getPathAttribute()
    {
        $url = $this->img_path;
        if (stristr($this->img_path, 'http') == false) {
            $url = 'storage/' . $this->img_path;
        }
        return $url;
    }
}
