<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UssdRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('UssdViewTableSeeder');

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_should_display_the_register_name_view()
    {
        $this->post(route('display-ussd.index'),$this->sessionData + [
            'text' => ''
        ])->assertSeeText("Enter your full name");
    }

    /** @test */
    public function it_should_display_the_register_pin_view()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'),$this->sessionData + [
                'text' => 'John Doe'
            ])->assertSeeText("Enter a new PIN");
    }

    /** @test */
    public function it_should_display_confirm_pin_view()
    {
        $this->ussdPost()
            ->ussdPost('John Doe');

        $this->post(route('display-ussd.index'),$this->sessionData + [
                'text' => '1234'
            ])->assertSeeText("Confirm your PIN");
    }

    /** @test */
    public function it_should_display_register_success_view_when_confirm_pin_matches_entered_pin()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234');

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => 'John Doe*1234*1234'
            ])
            ->assertSeeText('Your registration was successful');
    }

    /** @test */
    public function a_successful_registration_should_create_a_user()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234')
            ->ussdPost('John Doe*1234*1234');

        $this->assertDatabaseHas('users', ['name' => 'John Doe']);
    }

    /** @test */
    public function it_should_delete_the_session_when_its_complete()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234');

        $this->assertDatabaseHas('ussd_sessions', ['session_id' => $this->sessionData['sessionId']]);

        $this->ussdPost('John Doe*1234*1234');

        $this->assertDatabaseMissing('ussd_sessions', ['session_id' => $this->sessionData['sessionId']]);
    }


    /** @test */
    public function it_should_display_register_failure_when_pin_and_confirm_pin_dont_match()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234');

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => 'John Doe*1234*1235'
            ])
            ->assertSeeText('We were unable to register you');
    }


}
