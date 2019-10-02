<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\UssdView;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(UssdView::class, function (Faker $faker) {
    return [
        'name' => Str::slug($faker->sentence(2)),
        'body' => $faker->sentence,
    ];
});


/*
   -----------------
   REGISTER VIEWS
   -----------------
*/
$factory->state(UssdView::class, 'register-name', [
    'name' => 'register-name',
    'body' => 'CON Enter your full name',
]);

$factory->state(UssdView::class, 'register-pin', [
    'name' => 'register-pin',
    'body' => 'CON Enter a new PIN',
]);

$factory->state(UssdView::class, 'register-confirm-pin', [
    'name' => 'register-confirm-pin',
    'body' => 'CON Confirm your PIN',
]);

$factory->state(UssdView::class, 'register-successful', [
    'name' => 'register-successful',
    'body' => 'END Your registration was successful. Please dial shortcode again to login.',
]);

$factory->state(UssdView::class, 'register-failure', [
    'name' => 'register-failure',
    'body' => 'END We were unable to register you. Please dial shortcode again to login.',
]);

/*
   -----------------
   LOGIN VIEWS
   -----------------
*/
$factory->state(UssdView::class, 'login-prompt', [
    'name' => 'login-prompt',
    'body' => "CON Enter your PIN",
]);

$factory->state(UssdView::class, 'login-failed', [
    'name' => 'login-failed',
    'body' => "END You entered the wrong PIN. Try again",
]);

$factory->state(UssdView::class, 'main-menu', [
    'name' => 'main-menu',
    'body' => "CON 1. View Products\n2. Previous Orders\n3. My Account",
    'is_menu' => true,
]);

$factory->state(UssdView::class, 'product-menu', [
    'name' => 'product-menu',
    'body' => "CON 1. Fruits\n2. Vegetables\n3. Spices",
    'is_menu' => true,
]);

$factory->state(UssdView::class, 'view-orders', [
    'name' => 'view-orders',
    'body' => "END {orders}"
]);

