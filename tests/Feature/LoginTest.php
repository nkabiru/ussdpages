<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['phone_number' => $this->sessionData['phoneNumber']]);

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_shows_the_enter_pin_to_login_page()
    {
        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => ''])
            ->assertSeeText('Enter your PIN');
    }

    /** @test */
    public function it_should_show_the_main_menu_after_successful_login()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234'])
            ->assertSeeText('Main Menu');
    }

    /** @test */
    public function it_should_show_login_failed_page_if_pins_dont_match()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1235'])
            ->assertSeeText('You have entered the wrong PIN');
    }


}
