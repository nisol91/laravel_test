<?php

use App\Models\AlbumCategory;
use App\Models\AlbumsCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AlbumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // questa complessa funzione nested mi popola la tabella ponte con le categorie, al tempo della
        // creazione dei seed del singolo album
        factory(App\Models\Album::class, 30)->create()
            ->each(function ($album) {
                $cats = AlbumCategory::inRandomOrder()->take(3)->pluck('id');
                $cats->each(
                    function ($cat_id) use ($album) {
                        AlbumsCategory::create(
                            [
                                'album_id' => $album->id,
                                'category_id' => $cat_id
                            ]
                        );
                    }
                );
            });
    }
}
