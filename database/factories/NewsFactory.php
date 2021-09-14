<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\NewsModel;
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

$factory->define(NewsModel::class, function () {
    return [
        'userid' => 1,
        'title' => 'asdasdasdsdasdasd sa dasd',
        'description' => 'asdsaddasdsadadasdasd',
        'likes' => 0,
    ];
});
