<?php

namespace App\State\Login;

use App\State\State;
use App\UssdSession;

class MainContext
{
    public $state;

    public function __construct(UssdSession $session)
    {
        $this->state = new Initial($this, $session);
    }

    public function input($input)
    {
        $this->state->input($input);
    }

    public function view()
    {
        return $this->state->view();
    }

    public function changeState(State $state)
    {
        $this->state = $state;
    }

    public function getState()
    {
        return $this->state;
    }
}
