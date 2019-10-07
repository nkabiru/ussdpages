<?php

namespace App\State\Registration;

use App\UssdSession;
use App\UssdView;

class RegisterName implements UssdState
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
        $view = UssdView::where('name', 'register-name')->first();
        $this->session->makeCurrentView($view);

        $this->context->changeState(new EnterPin($this->context, $this->session));
    }

    public function pin(): void
    {
        // TODO: Implement pin() method.
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
