<?php

namespace Tests\Feature;

use App\Jobs\SendSmsReportToUser;
use App\User;
use App\UssdSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendSmsReportTest extends TestCase
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
    public function it_should_display_an_info_message_stating_that_an_sms_will_be_sent()
    {
        $this->ussdPost()
            ->ussdPost('1234');

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*4'])
            ->assertSeeText('We will send you an Item Report via SMS shortly.');
    }

    /** @test */
    public function it_should_delete_the_session_when_complete()
    {
        $this->ussdPost()
            ->ussdPost('1234');

        $this->post(route('display-ussd.index'), $this->sessionData + ['text' => '1234*4']);

        $this->assertDatabaseMissing('ussd_sessions', ['session_id' => $this->sessionData['sessionId']]);
    }


}
