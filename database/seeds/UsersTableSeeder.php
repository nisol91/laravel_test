<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $sql = 'INSERT INTO users (name, email, password)';
        // $sql .= 'values (:name, :email, :password)';


        // for ($i = 0; $i < 30; $i++) {
        //     DB::statement($sql, [
        //         'name' => Str::random(),
        //         'email'
        //         => Str::random() . '@gmail'
        //             . Str::random(),
        //         'password' => Hash::make('password')
        //     ]);
        // }

        // un metodo migliore è questo pero:
        // for ($i = 0; $i < 30; $i++) {
        //     DB::table('users')->insert([
        //         'name' => Str::random(),
        //         'email'
        //         => Str::random() . '@gmail'
        //             . Str::random(),
        //         'password' => Hash::make('password'),
        //         'created_at' => Carbon::now()
        //     ]);
        // }


        //ma il metodo piu moderno è usare le factory

        factory(App\User::class, 30)->create();
    }
}
