<?php

namespace Tests\Feature;

use App\User;
use App\UssdView;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UssdMainMenuTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create([
            'phone_number' => $this->sessionData['phoneNumber']
        ]);

        $this->seed('UssdViewTableSeeder');
    }

    /** @test */
    public function it_should_navigate_to_the_first_main_menu_option()
    {
        $this->ussdPost()
            ->ussdPost('1234');

        $view = UssdView::where('name', 'main-menu')->first();
        $expectedView = $view->nextViews->first();

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*1'])
            ->assertSeeText($expectedView->body);
    }

    /** @test */
    public function it_should_navigate_to_the_second_main_menu_option()
    {
        $this->ussdPost()
            ->ussdPost('1234');

        $view = UssdView::where('name', 'main-menu')->first();
        $expectedView = $view->nextViews[1];

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*2'])
            ->assertSeeText($expectedView->body);
    }

    /** @test */
    public function it_should_navigate_to_the_third_main_menu_option()
    {
        $this->ussdPost()
            ->ussdPost('1234');

        $view = UssdView::where('name', 'main-menu')->first();
        $expectedView = $view->nextViews[2];

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*3'])
            ->assertSeeText($expectedView->body);
    }


}
