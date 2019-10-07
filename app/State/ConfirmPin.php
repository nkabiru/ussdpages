<?php

namespace App\State;

class ConfirmPin implements UnregisteredUssdState
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
    }

    public function pinMatch(): void
    {
        // TODO: Implement pinMatch() method.
        echo "END You have successfully registered.";

        $this->context->changeState(new CreateUser($this->context));
    }

    public function pinMisMatch(): void
    {
        // TODO: Implement pinMisMatch() method.
        echo "PINs are not the same";

        $this->context->changeState(new $this($this->context));
    }
}
