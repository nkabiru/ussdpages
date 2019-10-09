<?php

namespace Tests\Feature;

use App\Item;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveItemTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $item;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['phone_number' => $this->sessionData['phoneNumber']]);
        $this->item = factory(Item::class)->create(['user_id' => $this->user->id]);

        $this->withoutExceptionHandling();
    }

    /** @test */
    public function it_should_display_prompt_to_enter_the_item_name()
    {
        $this->ussdPost('')
            ->ussdPost('1234');

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*2'])
            ->assertSeeText("Enter the name of the item to be removed:");
    }

    /** @test */
    public function it_should_display_prompt_to_enter_the_item_quantity()
    {
        $itemName = $this->item->name;

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*2');

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => "1234*2*$itemName"
            ])
            ->assertSeeText("Remove how many?");
    }

    /** @test */
    public function it_should_remove_the_item_and_display_an_info_message()
    {
        $itemName = $this->item->name;
        $itemQuantity = 1;
        $newQuantity = $this->item->quantity - 1;

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*2')
            ->ussdPost("1234*2*$itemName");

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => "1234*2*$itemName*$itemQuantity"
            ])
            ->assertSeeText("You have successfully removed the item");

        $this->assertDatabaseHas('items', ['name' => $itemName, 'quantity' => $newQuantity]);
    }

    /** @test */
    public function it_should_delete_the_session_after_removing_the_item()
    {
        $itemName = $this->item->name;
        $itemQuantity = $this->item->quantity;

        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*2')
            ->ussdPost("1234*2*$itemName");

        $this->post(route('display-ussd.index'), $this->sessionData + [
                'text' => "1234*2*$itemName*$itemQuantity"
            ]);

        $this->assertDatabaseMissing('ussd_sessions', ['session_id' => $this->sessionData['sessionId']]);
    }
}
