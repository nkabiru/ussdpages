<?php

namespace App\State;

class RegisterName implements UnregisteredUssdState
{
    /**
     * @var UnregisteredUssdContext
     */
    private $context;

    public function __construct(UnregisteredUssdContext $context)
    {
        $this->context = $context;
    }

    public function name(): void
    {
        // TODO: Implement name() method.
        echo 'CON Enter your name:';

        $this->context->changeState(new EnterPin($this->context));
    }

    public function pin(): void
    {
        // TODO: Implement pin() method.
    }

    public function pinMatch(): void
    {
        // TODO: Implement pinMatch() method.
    }

    public function pinMisMatch(): void
    {
        // TODO: Implement pinMisMatch() method.
    }
}
