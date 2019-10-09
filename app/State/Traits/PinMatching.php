<?php

namespace App\State\Traits;

use App\State\Registration\EnterPin;

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
