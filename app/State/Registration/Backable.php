<?php


namespace App\State\Registration;


trait Backable
{
    private function isBackButton(string $input)
    {
        return $input === '#';
    }
}
