<?php

namespace App\Ussd\Registration;

use App\Jobs\CreateUserInDatabase;
use App\Ussd\State;
use App\Ussd\Traits\DeletesUssdSessions;
use App\UssdSession;

class CreateUser implements State
{
    use DeletesUssdSessions;

    private $context;
    private $session;

    public function __construct(RegistrationContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
        $this->session->update(['state' => static::class]);
    }

    public function input($input): void
    {

    }

    /**
     *  Creating the user here because the input function won't be hit by the user.
     *  Same goes for deleting the UssdSession.
     *
     * @return string
     */
    public function view()
    {
        $this->createUser();
        $this->deleteSession();

        return "END You have registered successfully. Please dial the shortcode again to login";
    }

    protected function createUser(): void
    {
        $inputHistory = $this->session->input_history;

        CreateUserInDatabase::dispatchNow([
            'name' => $inputHistory[EnterName::class],
            'pin' => $inputHistory[EnterPin::class],
            'phone_number' => $this->session->phone_number
        ]);
    }

}
