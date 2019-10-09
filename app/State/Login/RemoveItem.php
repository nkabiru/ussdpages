<?php

namespace App\State\Login;

use App\State\State;
use App\UssdSession;

class RemoveItem implements State
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
        return "CON Enter name of item to remove:";
    }
}
