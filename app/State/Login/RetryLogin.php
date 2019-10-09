<?php

namespace App\State\Login;

class RetryLogin extends Login
{
    public function view()
    {
        return "CON You have entered the wrong PIN. Please try again:";
    }
}
