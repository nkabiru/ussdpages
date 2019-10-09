<?php

namespace App\State\Login;

use App\State\State;
use App\State\Traits\PinMatching;
use App\State\Traits\SavesInputHistory;
use App\UssdSession;
use Illuminate\Support\Facades\Hash;

class Login implements State
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

        $nextState = $this->isPinCorrect($input) ? new MainMenu($this->context, $this->session)
           : new RetryLogin($this->context, $this->session);

        $this->context->changeState($nextState);
    }

    public function view()
    {
        return "CON Enter your PIN";
    }

    protected function isPinCorrect($pin)
    {
        return Hash::check($pin, $this->session->user->pin);
    }
}
