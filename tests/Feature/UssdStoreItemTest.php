<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UssdStoreItemTest extends TestCase
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
    public function it_should_display_prompt_to_enter_the_item_name()
    {
        $this->ussdPost('')
            ->ussdPost('1234');

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*1'])
            ->assertSeeText("Enter item name:");
    }

    /** @test */
    public function it_should_display_prompt_to_enter_the_item_quantity()
    {
        $itemName = 'Pen';

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*1');

        $this->post(route('display-ussd.index'), $this->sessionData + [
            'text' => "1234*1*$itemName"
            ])
        ->assertSeeText("Enter item quantity:");
    }

    /** @test */
    public function it_should_save_the_item_and_display_an_info_message()
    {
        $itemName = 'Pens';
        $itemQuantity = '5';

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*1')
            ->ussdPost("1234*1*$itemName");

        $this->post(route('display-ussd.index'), $this->sessionData + [
            'text' => "1234*1*$itemName*$itemQuantity"
            ])
        ->assertSeeText("Your item was stored successfully!");

        $this->assertDatabaseHas('items', ['name' => $itemName, 'quantity' => $itemQuantity]);
    }

    /** @test */
    public function it_should_delete_the_session_after_saving_the_item()
    {
        $itemName = 'Pens';
        $itemQuantity = '5';

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*1')
            ->ussdPost("1234*1*$itemName");

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => "1234*1*$itemName*$itemQuantity"
            ])
            ->assertSeeText("Your item was stored successfully!");

        $this->assertDatabaseMissing('ussd_sessions', ['session_id' => $this->sessionData['sessionId']]);
    }


}
