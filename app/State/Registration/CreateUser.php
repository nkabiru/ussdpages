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
       if ($this->pinMatches($input)) {
          echo "Creating user";
       }
    }


    public function view()
    {
        // TODO: Implement view() method.
    }
}
