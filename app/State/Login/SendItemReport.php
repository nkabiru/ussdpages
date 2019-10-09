<?php

namespace App\State\Login;

use App\Jobs\SendSmsReportToUser;
use App\State\State;
use App\State\Traits\DeletesUssdSessions;
use App\UssdSession;

class SendItemReport implements State
{
    use DeletesUssdSessions;

    protected $context;
    protected $session;

    public function __construct(MainContext $context, UssdSession $session)
    {
        $this->context = $context;
        $this->session = $session;
    }

    public function input(string $input)
    {
        return;
    }

    public function view()
    {
        $this->sendReport();
        $this->deleteSession();

        return "END We will send you an Item Report via SMS shortly.";
    }

    protected function sendReport()
    {
        SendSmsReportToUser::dispatchNow($this->session->user);
    }
}
