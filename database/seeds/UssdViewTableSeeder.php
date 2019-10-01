<?php

use App\UssdView;
use Illuminate\Database\Seeder;

class UssdViewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Registration views
        factory(UssdView::class)->state('register-name')->create();
        factory(UssdView::class)->state('register-pin')->create();
        factory(UssdView::class)->state('register-confirm-pin')->create();
        factory(UssdView::class)->state('register-successful')->create();
        factory(UssdView::class)->state('register-failure')->create();

        // Main views
        factory(UssdView::class)->state('login')->create();
        factory(UssdView::class)->state('login-prompt')->create();
        factory(UssdView::class)->state('main-menu')->create();
        factory(UssdView::class)->state('view-products')->create();

    }
}
