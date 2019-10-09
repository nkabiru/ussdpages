<?php

namespace App\Ussd\Traits;

use App\Ussd\Registration\EnterPin;

trait PinMatching
{
    protected function pinMatches(string $input)
    {
        return $this->session->fresh()->input_history[EnterPin::class] === $input;
    }

    protected function pindoesntMatch(string $input)
    {
        return ! $this->pinMatches($input);
    }
}
