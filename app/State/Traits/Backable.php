<?php

namespace App\State\Traits;

trait Backable
{
    private function isBackButton(string $input)
    {
        return $input === '#';
    }
}
