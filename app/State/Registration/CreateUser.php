<?php

namespace App\State\Registration;

use App\Jobs\CreateUserInDatabase;
use App\UssdSession;

class CreateUser implements State
{
    use PinMatching;

    private $context;
    private $session;

    public function __construct(StateContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
        $this->session->update(['state' => static::class]);
    }

    public function input($input): void
    {
        $previousInputs = explode('*', request('text'));

        CreateUserInDatabase::dispatchNow([
            'name' => $previousInputs[-2],
            'phone_number' => request('phoneNumber'),
            'pin' => $input
        ]);
    }


    public function view()
    {
        return "END You have registered successfully. Please dial the shortcode again to login";
    }
}
