<?php

namespace App\Ussd\Login;

use App\Ussd\State;
use App\UssdSession;

class Initial implements State
{
    protected $context;
    protected $session;

    public function __construct(MainContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
    }

    public function input(string $input)
    {
        $this->context->changeState(new Login($this->context, $this->session));
    }

    public function view()
    {
        return "END Welcome to the USSD menu";
    }
}
