<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UssdSession;
use Faker\Generator as Faker;

$factory->define(UssdSession::class, function (Faker $faker) {
    return [
        'session_id' => 'ATU_id' . $faker->md5,
        'phone_number' => $faker->numerify('+2540########')
    ];
});
