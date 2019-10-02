<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UssdLoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('UssdViewTableSeeder');
        $this->user = factory(User::class)->create(['phone_number' => $this->sessionData['phoneNumber']]);

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_shows_the_enter_pin_to_login_page()
    {
        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => ''])
            ->assertSeeText(ussd_view('login-prompt'));
    }

    /** @test */
    public function it_should_show_the_main_menu_after_successful_login()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234'])
            ->assertSeeText(ussd_view('main-menu'));
    }

    /** @test */
    public function it_should_show_login_failed_page_if_pins_dont_match()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1235'])
            ->assertSeeText(ussd_view('login-failed'));
    }


}
