<?php

namespace App\State\Registration;

interface State
{
    public function input(string $input);

    public function view();
}
