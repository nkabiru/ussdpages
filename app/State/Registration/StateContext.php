<?php

namespace App\State\Registration;

use App\UssdSession;

class StateContext
{
    /**
     * @var RegisterName
     */
    public $state;

    public function __construct(UssdSession $session)
    {
        $this->state = new RegisterName($this, $session);
    }

    public function name()
    {
        $this->state->name();
    }

    public function pin()
    {
        $this->state->pin();
    }

    public function pinMatch()
    {
        $this->state->pinMatch();
    }

    public function pinMisMatch()
    {
        $this->state->pinMisMatch();
    }

    public function changeState(UssdState $state)
    {
        $this->state = $state;
    }
}
