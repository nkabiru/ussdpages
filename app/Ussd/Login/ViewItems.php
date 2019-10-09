<?php

namespace App\Ussd\Login;

use App\Ussd\State;
use App\Ussd\Traits\Backable;
use App\UssdSession;
use Illuminate\Support\Str;

class ViewItems implements State
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
        $this->context->changeState(new MainMenu($this->context, $this->session));
    }

    public function view()
    {
        return $this->itemList();
    }

    protected function itemList()
    {
        $items = $this->session->user->items()->latest()->take(5)->get();
        $str = '';

        foreach ($items as $key => $item) {
            $str .= $key + 1 . ". $item->name x $item->quantity\n";
        }

        return "CON Your Last 5 Stored Items:\n" . $str;
    }
}
