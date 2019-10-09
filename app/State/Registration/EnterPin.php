<?php

namespace App\State\Registration;

use App\State\State;
use App\State\Traits\SavesInputHistory;
use App\UssdSession;

class EnterPin implements State
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

        $this->context->changeState(new ConfirmPin($this->context, $this->session));
    }

    public function view()
    {
        return "CON Enter a new PIN";
    }

}
