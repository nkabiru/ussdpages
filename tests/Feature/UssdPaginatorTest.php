<?php

namespace Tests\Feature;

use App\User;
use App\UssdView;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UssdPaginatorTest extends TestCase
{
    use RefreshDatabase;

    private $sessionId;
    private $user;
    private $testData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->state('ussd-pin')->create();
        $this->sessionId = "ATU_id" . sha1($this->user->name);
        $this->testData = ['sessionId' => $this->sessionId, 'phoneNumber' => $this->user->phone_number];

        $this->withoutExceptionHandling();
        $this->seed('UssdViewTableSeeder');
    }

    /** @test */
    public function the_view_should_have_a_string_body()
    {
        $this->assertNotNull(UssdView::first());
    }

    /** @test */
    public function it_should_display_the_login_menu()
    {
        $view = UssdView::where('name', 'login')->value('body');

        $this->post(route('ussd-view.index'), $this->testData + [
            'text' => ''
        ])->assertSeeText($view);
    }

    /** @test */
    public function it_should_display_a_login_prompt()
    {
        $view = UssdView::where('name', 'login-prompt')->value('body');

        $this->assertIsString($view);

        $this->post(route('ussd-view.index'), $this->testData + ['text' => '']);

        $this->post(route('ussd-view.index'), $this->testData + [
            'text' => '1'
        ])->assertSeeText($view);
    }

    /** @test */
    public function it_should_display_the_main_menu_if_login_successful()
    {
        $view = UssdView::where('name', 'main-menu')->value('body');

        $this->assertIsString($view);

        $this->post(route('ussd-view.index'), $this->testData + [
            'text' => '1*1234',
        ])->assertSeeText($view);
    }


}
