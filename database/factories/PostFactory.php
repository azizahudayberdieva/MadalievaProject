<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

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

$factory->define(\App\Models\Post::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'user_id' => function() {
            return factory(App\Models\User::class)->create()->id;
        },
        'category_id' => function() {
            return factory(App\Models\Category::class)->create()->id;
        },
        'description' => $faker->text,
        'order' => mt_rand(1, 3), // password
    ];
});
