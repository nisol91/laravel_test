<?php

use App\Models\AlbumCategory;
use Illuminate\Database\Seeder;

class SeedAlbumCategoriesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'viaggi',
            'natura',
            'sport',
            'alpinismo',
            'trail running'
        ];

        foreach ($categories as $cat) {
            AlbumCategory::create(
                ['category_name' => $cat]
            );
        }
    }
}
