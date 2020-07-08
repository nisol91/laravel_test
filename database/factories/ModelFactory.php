<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
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

$categories = [
    'cats',
    'nature',
    'animals'
];

// use () serve per utilizzare globalmente una qualsiasi variabile
$factory->define(Photo::class, function (Faker $faker) use ($categories) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl($width = 640, $height = 480, $faker->randomElement($categories)),
        // 'album_id' => Album::inRandomOrder()->first()->id,
        'album_id' => 50,

    ];
});

$factory->define(Album::class, function (Faker $faker) use ($categories) {
    return [
        'album_name' => $faker->name,
        'description' => $faker->text(128),
        'user_id' => User::inRandomOrder()->first()->id,
        'album_thumb' => $faker->imageUrl($width = 120, $height = 120, $faker->randomElement($categories))
    ];
});
