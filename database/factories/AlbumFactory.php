<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Album::class, function (Faker $faker) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        'user_id' => User::inRandomOrder()->first()->id,
    ];
});