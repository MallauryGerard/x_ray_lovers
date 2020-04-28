<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\Patient;
use App\Hospital;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Enums\Urgency;

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

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        //'scheduled_date' => $faker->dateTimeBetween('+0 days', '+2 days'),
        'scheduled_date' => "2020-04-27",
        'urgency' => $faker->randomElement([Urgency::Low, Urgency::Medium, Urgency::Hight]),
        'comment' => $faker->randomElement([null, $faker->text]),
        'exam_id' => rand(1,3),
        'patient_id' => rand(1,200),
        'hospital_id' => rand(1,3),
        'slot_id' => rand(1,26)
    ];
});
