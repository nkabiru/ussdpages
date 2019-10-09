<?php


namespace App\Ussd\Traits;


trait DeletesUssdSessions
{
    protected function deleteSession()
    {
        $this->session->delete();
    }
}
