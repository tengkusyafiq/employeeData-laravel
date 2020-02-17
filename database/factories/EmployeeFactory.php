<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'phone' => $faker->phoneNumber(),
        'email' => $faker->safeEmail(),
        'kpi' => $faker->randomFloat($nbMaxDecimals = null, $min = 50, $max = 100),
    ];
});
