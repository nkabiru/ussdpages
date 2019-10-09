<?php

namespace App\State\Traits;

trait SavesInputHistory
{
    protected function saveInputHistory(string $input)
    {
        $inputHistory = $this->session->input_history ?? [];
        $inputHistory += [static::class => $input];

        $this->session->input_history = $inputHistory;
        $this->session->save();
    }
}
