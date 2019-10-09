<?php

namespace App\State\Registration;

use App\UssdSession;
use App\UssdView;

class EnterName implements State
{
    use SavesInputHistory;

    private $context;
    private $session;

    public function __construct(StateContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
        $this->session->update(['state' => static::class]);
    }

    public function input(string $input)
    {
        $this->saveInputHistory($input);

        $this->context->changeState(new EnterPin($this->context, $this->session));
    }

    public function view()
    {
        return "CON Enter your name";
    }
}
