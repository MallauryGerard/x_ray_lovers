<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Enums\Gender;

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

$factory->define(Patient::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstname,
        'lastname' => $faker->lastname,
        'birthdate' => $faker->dateTimeThisCentury(),
        'gender' => $faker->randomElement([Gender::Man, Gender::Woman, Gender::Other]),
        'phone_number' => $faker->unique()->phoneNumber,
        'email' => $faker->randomElement([$faker->unique()->safeEmail, null])
    ];
});
