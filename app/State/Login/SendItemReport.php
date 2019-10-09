<?php

namespace App\State\Login;

use App\State\State;
use App\UssdSession;

class SendItemReport implements State
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

    }

    public function view()
    {
        return "END We will send you an Item Report via SMS shortly.";
    }
}
