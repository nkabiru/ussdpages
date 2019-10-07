<?php

namespace App\State;

class UnregisteredUssdContext
{
    /**
     * @var RegisterName
     */
    private $state;

    public function __construct()
    {
        $this->state = new RegisterName($this);
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

    public function changeState(UnregisteredUssdState $state)
    {
        $this->state = $state;
    }
}
