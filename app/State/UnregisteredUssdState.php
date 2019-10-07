<?php

namespace App\State;

interface UnregisteredUssdState
{
    public function name(): void ;

    public function pin(): void ;

    public function pinMatch(): void ;

    public function pinMisMatch(): void ;
}
