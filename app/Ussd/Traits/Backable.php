<?php

namespace App\Ussd\Traits;

trait Backable
{
    private function isBackButton(string $input)
    {
        return $input === '#';
    }
}
