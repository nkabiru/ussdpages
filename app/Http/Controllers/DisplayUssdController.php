<?php

namespace App\Http\Controllers;

use App\User;
use App\Ussd\Login\MainContext;
use App\Ussd\Registration\RegistrationContext;
use App\UssdSession;
use Illuminate\Http\Request;

class DisplayUssdController
{
    public function __invoke(Request $request)
    {
        $input = last(explode('*', $request->input('text')));

        $session = UssdSession::firstOrCreate([
            'session_id' => $request->sessionId,
            'phone_number' => $request->phoneNumber,
        ]);

        if ($user = User::where('phone_number', $request->phoneNumber)->first()) {
            $session->user()->associate($user);
            $session->save();
        }

        $context = $session->user ? new MainContext($session) : new RegistrationContext($session);

        if (! is_null($session->state)) {
            $context->changeState(new $session->state($context, $session));
        }

        $context->input($input);

        return $context->view();
    }
}
