<?php

namespace Tests\Feature;

use App\Item;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewItemsTest extends TestCase
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
    public function it_displays_a_list_of_latest_items_to_the_user()
    {
        $items = factory(Item::class, 7)->create(['user_id' => $this->user->id]);

        $this->ussdPost('')
            ->ussdPost('1234');

        $firstItem = "1. " . $items[0]->name . " x " . $items[0]->quantity;
        $fifthItem = "5. " . $items[4]->name . " x " . $items[4]->quantity;

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*3'])
            ->assertSeeText($firstItem)
            ->assertSeeText($fifthItem);
    }

    /** @test */
    public function pressing_any_button_should_take_the_user_back_to_the_main_menu()
    {
        $this->ussdPost('')
            ->ussdPost('1234')
            ->ussdPost('1234*3');

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*3*a'])
            ->assertSeeText('Main Menu');
    }


}
