<?php


namespace App\State\Traits;


trait DeletesUssdSessions
{
    protected function deleteSession()
    {
        $this->session->delete();
    }
}
