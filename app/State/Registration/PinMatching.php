<?php


namespace App\State\Registration;


trait PinMatching
{
    protected function pinMatches(string $input)
    {
        return $this->session->input_history[EnterPin::class] === $input;
    }

    protected function pindoesntMatch(string $input)
    {
        return ! $this->pinMatches($input);
    }
}
