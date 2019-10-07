<?php

namespace App\State\Registration;

interface UssdState
{
    public function name(): void ;

    public function pin(): void ;

    public function pinMatch(): void ;

    public function pinMisMatch(): void ;
}
