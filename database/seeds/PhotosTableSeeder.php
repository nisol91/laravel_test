<?php

use App\Models\Album;
use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //prendo tutti gli album
        $albums = Album::get();
        foreach ($albums as $album) {
            // fa andare le funzioni delle factories
            factory(App\Models\Photo::class, 50)->create(
                ['album_id' => $album->id]
            );
        }
    }
}
