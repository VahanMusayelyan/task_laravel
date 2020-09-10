<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Section;
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





$factory->define(App\Section::class, function ($faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'logo' => 'logo/partnership.jpg'
    ];
});

