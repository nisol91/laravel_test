<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Album;
use App\Models\Photo;
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

$factory->define(Photo::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text(128),
        'img_path' => $faker->imageUrl($width = 640, $height = 480, 'cats'),
        'album_id' => Album::inRandomOrder()->first()->id,
    ];
});
