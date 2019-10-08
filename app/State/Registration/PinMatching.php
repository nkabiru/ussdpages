<?php


namespace App\State\Registration;


trait PinMatching
{
    private function pinMatches(string $input)
    {
        return !! $input;
    }

    private function pindoesntMatch(string $input)
    {
        return ! $input;
    }
}
