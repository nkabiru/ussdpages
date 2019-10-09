<?php

namespace App\State\Registration;

use App\State\State;
use App\UssdSession;

class Initial implements State
{
    private $context;
    private $session;

    public function __construct(RegistrationContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
    }

    public function input($input)
    {
        $this->context->changeState(new EnterName($this->context, $this->session));
    }

    public function view()
    {
        return 'initial';
    }
}
