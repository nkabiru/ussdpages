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
        $this->deleteUssdSession();

        return "END You have registered successfully. Please dial the shortcode again to login";
    }

    protected function createUser(): void
    {
        $inputHistory = $this->session->input_history;

        CreateUserInDatabase::dispatchNow([
            'name' => $inputHistory[EnterName::class],
            'pin' => $inputHistory[EnterPin::class],
            'phone_number' => request('phoneNumber')
        ]);
    }

    protected function deleteUssdSession()
    {
        $this->session->delete();
    }


}
