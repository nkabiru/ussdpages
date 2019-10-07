<?php

namespace App\State\Registration;

use App\UssdSession;
use App\UssdView;

class EnterPin implements UssdState
{
    /**
     * @var StateContext
     */
    private $context;
    /**
     * @var UssdSession
     */
    private $session;

    public function __construct(StateContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
    }

    public function name(): void
    {
        // TODO: Implement name() method.
    }

    public function pin(): void
    {
        // TODO: Implement pin() method.
        $view = UssdView::where('name', 'register-pin')->first();
        $this->session->makeCurrentView($view);

        $this->context->changeState(new ConfirmPin($this->context, $this->session));
    }

    public function pinMatch(): void
    {
        // TODO: Implement pinMatch() method.
    }

    public function pinMisMatch(): void
    {
        // TODO: Implement pinMisMatch() method.
    }
}
