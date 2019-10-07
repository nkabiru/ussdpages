<?php

namespace App\State\Registration;

use App\UssdSession;

class ConfirmPin implements UssdState
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
    }

    public function pinMatch(): void
    {
        // TODO: Implement pinMatch() method.
        $view = UssdView::where('name', 'register-successful')->first();
        $this->session->makeCurrentView($view);

        $this->context->changeState(new CreateUser($this->context));
    }

    public function pinMisMatch(): void
    {
        // TODO: Implement pinMisMatch() method.
        $view = UssdView::where('name', 'register-failed')->first();
        $this->session->makeCurrentView($view);

        $this->context->changeState(new $this($this->context));
    }
}
