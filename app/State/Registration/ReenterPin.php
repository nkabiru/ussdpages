<?php

namespace App\State\Registration;

class ReenterPin extends ConfirmPin
{
    public function view()
    {
        return "CON The PINs did not match. Please try to confirm it again:";
    }
}
