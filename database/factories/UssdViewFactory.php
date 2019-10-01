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

$factory->state(UssdView::class, 'login', [
    'name' => 'login',
    'body' => "CON 1. Login \n2. Register\n",
    'is_menu' => true,
]);

$factory->state(UssdView::class, 'login-prompt', [
    'name' => 'login-prompt',
    'body' => "CON Enter your PIN",
    'previous_view_id' => function () {
        return UssdView::where('name', 'login')->value('id')
            ?? factory(UssdView::class)->state('login')->create()->id;
    }
]);

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
    'body' => 'END Your registration was successful. Please enter {key} to login',
]);
$factory->state(UssdView::class, 'register-failure', [
    'name' => 'register-failure',
    'body' => 'END We were unable to register you. Please enter {key} to try again.',
]);


$factory->state(UssdView::class, 'main-menu', [
    'name' => 'main-menu',
    'body' => "CON 1. Products \n2. Cart\n3. Previous Purchases\n4. My Account",
    'is_menu' => true,
    'previous_view_id' => function () {
        return UssdView::where('name', 'login-prompt')->value('id')
            ?? factory(UssdView::class)->state('login-prompt')->create()->id;
    }
]);

$factory->state(UssdView::class, 'view-products', [
    'name' => 'view-products',
    'body' => 'CON 1. Bread\n2. Cupcake\n3. Pancakes'
]);
