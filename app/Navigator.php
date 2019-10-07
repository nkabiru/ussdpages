<?php

namespace App;

use App\Jobs\CreateUserInDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    protected function saveState(string $viewName, string $input = null)
    {
        $state = $this->session->state ?? [];
        $state += [$viewName => $input];

        $this->session->state = $state;
        $this->session->save();
    }

    protected function displayFirstView()
    {
        if ($this->session->user) {
            $view = UssdView::where('name', 'login-prompt')->first();
        } else {
            $view = UssdView::where('name', 'register-name')->first();
        }

        $this->session->makeCurrentView($view);
    }

    protected function login(string $input)
    {
        $this->saveState($this->session->currentView->name, $input);

        if (Hash::check($input, $this->session->user->pin)) {
            $loginView = UssdView::where('name', 'login');
            $this->saveState($loginView->name, $input);
        }
    }

    protected function registerName($input)
    {
        $this->saveState($this->session->currentView->name, $input);

        $this->session->nextView();
    }

    protected function registerPin($input)
    {
        $this->saveState($this->session->currentView->name, $input);

        $this->session->nextView();
    }

    public function view()
    {
        if (is_null($this->session->state)) {
            $this->displayFirstView();
        }

        $registerName = UssdView::where('name', 'register-name')->first();

        if ($this->session->currentView->is($registerName) && $this->request->text != '') {
            $this->registerName(last($this->input));
        }

        return $this->session->currentView->body;
    }
}
