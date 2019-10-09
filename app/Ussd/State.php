<?php

namespace App\Ussd;

interface State
{
    public function input(string $input);

    public function view();
}
