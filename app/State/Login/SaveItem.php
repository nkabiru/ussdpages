<?php

namespace App\State\Login;

use App\Jobs\CreateItemInDatabase;
use App\State\State;
use App\State\Traits\DeletesUssdSessions;
use App\UssdSession;

class SaveItem implements State
{
    use DeletesUssdSessions;

    protected $context;
    protected $session;

    public function __construct(MainContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;

        $this->session->update(['state' => static::class]);
    }

    public function input(string $input)
    {
        return;
    }

    public function view()
    {
        $this->saveItem();
        $this->deleteSession();

        return "END Your item was stored successfully!";
    }

    protected function saveItem()
    {
        $inputHistory = $this->session->input_history;

        CreateItemInDatabase::dispatchNow($this->session->user, [
            'name' => $inputHistory[EnterItemName::class],
            'quantity' => $inputHistory[EnterItemQuantity::class]
        ]);
    }
}
