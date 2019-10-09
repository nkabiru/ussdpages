<?php

namespace App\Ussd\Registration;

use App\Ussd\State;
use App\Ussd\Traits\Backable;
use App\Ussd\Traits\PinMatching;
use App\Ussd\Traits\SavesInputHistory;
use App\UssdSession;

class ConfirmPin implements State
{
    use Backable, PinMatching, SavesInputHistory;

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

        if ($this->isBackButton($input)) {
            $this->context->changeState(new EnterPin($this->context, $this->session));
            return;
        }

        if ($this->pinMatches($input)) {
            $this->context->changeState(new CreateUser($this->context, $this->session));
        }

        if($this->pindoesntMatch($input)) {
            $this->context->changeState(new ReenterPin($this->context, $this->session));
        }
    }

    public function view()
    {
        return "CON Confirm your PIN\n(Press # to go back)";
    }
}
