<?php

namespace App;

use App\Jobs\CreateUserInDatabase;
use Illuminate\Http\Request;

class Navigator
{
    private $request;

    /**
     * @var UssdSession
     */
    private $session;
    /**
     * @var array
     */
    private $input;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->input = explode('*', $this->request->input('text'));

        $this->storeUssdSession();
        $this->attachUserToSession();
    }

    protected function storeUssdSession()
    {
        $this->session = UssdSession::firstOrCreate([
            'session_id' => $this->request->input('sessionId'),
            'phone_number' => $this->request->input('phoneNumber'),
        ]);
    }

    protected function attachUserToSession()
    {
        if ($user = User::where('phone_number', $this->request->phoneNumber)->first()) {
            $this->session->user()->associate($user);
            $this->session->save();
        }
    }

    public function getView()
    {
        if(is_null($this->session->user)) {
            $this->registerUser();
        }

        if($this->session->user) {
            $this->loginUser();
        }
    }

    protected function registerUser()
    {
        $registerView = UssdView::where('name', 'register-name')->first();

        if (is_null($this->session->currentView)) {
            $this->session->makeCurrentView($registerView);
        }

        if ($this->session->currentView) {
            $this->handleRegistrationSequence();
        }
    }

    private function handleRegistrationSequence()
    {
        if ($this->session->currentView->isConfirmPinView()) {
            $this->confirmPin();
        }

        if ($this->session->currentView->isNotLast()) {
            return $this->session->nextView();
        }
    }

    private function confirmPin()
    {
        assertTrue($this->session->currentView->name === 'register-confirm-pin');

        if ($this->input[1] !== $this->input[2]) {
            $failedRegistrationView = UssdView::where('name', 'register-failure')->first();
            $this->session->makeCurrentView($failedRegistrationView);

            return $this->session->currentView;
        }

        return CreateUserInDatabase::dispatchNow([
            'name' => $this->input[0],
            'pin' => $this->input[1],
            'phone_number' => $this->request->input('phoneNumber')
        ]);
    }


}
