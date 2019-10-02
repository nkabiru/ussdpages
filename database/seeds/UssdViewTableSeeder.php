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
        $first = factory(UssdView::class)->state('register-name')->create();
        $second = factory(UssdView::class)->state('register-pin')->create(['previous_view_id' => $first->id]);
        $third = factory(UssdView::class)->state('register-confirm-pin')->create(['previous_view_id' => $second->id]);

        factory(UssdView::class)->state('register-successful')->create(['previous_view_id' => $third->id]);
        factory(UssdView::class)->state('register-failure')->create(['previous_view_id' => $third->id]);

        // Main views
        $loginPrompt = factory(UssdView::class)->state('login-prompt')->create();
        factory(UssdView::class)->state('login-failed')->create(['previous_view_id' => $loginPrompt->id]);
        $mainMenu = factory(UssdView::class)->state('main-menu')->create(['previous_view_id' => $loginPrompt->id]);

        factory(UssdView::class)->state('product-menu')->create(['previous_view_id' => $mainMenu->id]);
        factory(UssdView::class)->state('view-orders')->create(['previous_view_id' => $mainMenu->id]);

    }
}
