<?php

namespace App\Ussd\Registration;

use App\Ussd\State;
use App\Ussd\Traits\SavesInputHistory;
use App\UssdSession;

class EnterName implements State
{
    use SavesInputHistory;

    private $context;
    private $session;

    public function __construct(RegistrationContext $context, UssdSession $session)
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
        return "CON Enter your full name";
    }
}
