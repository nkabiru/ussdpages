<?php

namespace App\State\Login;

use App\State\State;
use App\State\Traits\SavesInputHistory;
use App\UssdSession;

class RemoveItemQuantity implements State
{
    use SavesInputHistory;

    protected $context;
    protected $session;

    public function __construct(MainContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;

        $this->session->update(['state' => static::class]);
    }

    public function input(string $input)
    {
        $this->saveInputHistory($input);

        $this->context->changeState(new RemoveItem($this->context, $this->session));
    }

    public function view()
    {
        return "CON Remove how many?";
    }
}
