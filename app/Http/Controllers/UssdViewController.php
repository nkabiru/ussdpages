<?php

namespace App\Http\Controllers;

use App\Jobs\CreateUserInDatabase;
use App\User;
use App\UssdSession;
use App\UssdView;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UssdViewController extends Controller
{
    public function index(Request $request)
    {
        if ($request->text == "") {
            if ($user = User::where('phone_number', $request->phoneNumber)->exists()) {
                return ussd_view('login-prompt');
            } else {
                return ussd_view('register-name');
            }
        } else {
            $inputArray = explode('*', $request->text);
            $history = [];


            if ($user = User::where('phone_number', $request->phoneNumber)->first()) {
                // Login sequence

            } else {
                // Register sequence
                if (count($inputArray) == 1) {
                    return ussd_view('register-pin');
                }

                if (count($inputArray) == 2) {
                    return ussd_view('register-confirm-pin');
                }

                if (count($inputArray) == 3) {
                    if ($inputArray[1] === $inputArray[2]) {
                        $this->dispatchNow(new CreateUserInDatabase([
                            'name' => $inputArray[0],
                            'pin' => $inputArray[2],
                            'phone_number' => $request->phoneNumber
                        ]));

                        return ussd_view('register-successful');
                    } else {
                        return ussd_view('register-failed');
                    }
                }

            }

        }


//        if ($request->text == '') {
//            $view = UssdView::where('name', 'login')->first();
//            $user->sessions()->create([
//                'session_id' => $request->sessionId,
//                'current_view_id' => $view->id,
//            ]);
//            return $view->body;
//        }
//
//        if ($user->sessions) {
//            $inputArray = explode('*', $request->text);
//            $session = $user->sessions()->first();
//            $currentView = $user->sessions()->first()->currentView;
//
//            if (!$session->nextView && $currentView->is_menu) {
//                $userInput = last($inputArray);
//            }
//
//            return $currentView->nextView->body;
//        }

            return "END Oops! Error";
    }
}
