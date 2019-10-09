<?php

namespace App\State\Login;

use App\State\State;
use App\State\Traits\PinMatching;
use App\UssdSession;

class MainMenu implements State
{
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
        switch ($input) {
            case '1':
               $nextState = new EnterItemName($this->context, $this->session);
               break;
            case '2':
               $nextState = new RemoveItem($this->context, $this->session);
               break;
            case '3':
               $nextState = new ViewItems($this->context, $this->session);
               break;
            case '4':
               $nextState = new SendItemReport($this->context, $this->session);
               break;
            default:
               $nextState = new static($this->context, $this->session);
        }

        $this->context->changeState($nextState);
    }

    public function view()
    {
        return "CON Main Menu:\n 1. Store an item\n2. Remove an item\n3. View Stored Items\n4. Get Item Report";
    }
}
