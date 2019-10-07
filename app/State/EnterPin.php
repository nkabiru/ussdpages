<?php

namespace App\State;

class EnterPin implements UnregisteredUssdState
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
    }

    public function pin(): void
    {
        // TODO: Implement pin() method.
        echo 'Enter a PIN:';

        $this->context->changeState(new ConfirmPin($this->context));
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
