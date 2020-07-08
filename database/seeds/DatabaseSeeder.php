<?php

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // questo run chiama tutti i seeder

        // qui posso chiamare tutti i seeds cancellando prima le tabelle, e posso farlo
        // con un unico comando php artisan db:seed

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Album::truncate();
        Photo::truncate();
        AlbumCategory::truncate();


        $this->call(UsersTableSeeder::class);
        $this->call(SeedAlbumCategoriesTable::class);
        $this->call(AlbumsTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
    }
}
