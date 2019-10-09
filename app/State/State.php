<?php

namespace App\State;

interface State
{
    public function input(string $input);

    public function view();
}
