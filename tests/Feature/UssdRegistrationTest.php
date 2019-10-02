<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class UssdRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private $data;
    private $text;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed('UssdViewTableSeeder');

        $this->data = [
            'sessionId' => 'ATU_id' . Str::random(),
            'phoneNumber' => "+254700000000"
        ];

        $this->withoutExceptionHandling();
    }

    public function ussdPost(string $data = '')
    {
        $this->post(route('display-ussd.index'), $this->data + ['text' => $data]);

        return $this;
    }

    /** @test */
    public function it_should_display_the_register_name_view()
    {
        $this->post(route('display-ussd.index'),$this->data + [
            'text' => ''
        ])->assertSeeText("Enter your full name");
    }

    /** @test */
    public function it_should_display_the_register_pin_view()
    {
        $this->ussdPost();

        $this->post(route('display-ussd.index'),$this->data + [
                'text' => 'John Doe'
            ])->assertSeeText("Enter a new PIN");
    }

    /** @test */
    public function it_should_display_confirm_pin_view()
    {
        $this->ussdPost()
            ->ussdPost('John Doe');

        $this->post(route('display-ussd.index'),$this->data + [
                'text' => '1234'
            ])->assertSeeText("Confirm your PIN");
    }

    /** @test */
    public function it_should_display_register_success_view_when_confirm_pin_matches_entered_pin()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234');

        $this->post(route('display-ussd.index'), $this->data + [
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
    public function it_should_display_register_failure_when_pin_and_confirm_pin_dont_match()
    {
        $this->ussdPost()
            ->ussdPost('John Doe')
            ->ussdPost('John Doe*1234');

        $this->post(route('display-ussd.index'), $this->data + [
                'text' => 'John Doe*1234*1235'
            ])
            ->assertSeeText('We were unable to register you');
    }


}
