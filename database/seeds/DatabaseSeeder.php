<?php

use App\Models\Album;
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
        // qui posso chiamare tutti i seeds cancellando prima le tabelle, e posso farlo
        // con un unico comando php artisan db:seed

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        User::truncate();
        Album::truncate();
        Photo::truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(AlbumsTableSeeder::class);
        $this->call(PhotosTableSeeder::class);
    }
}
