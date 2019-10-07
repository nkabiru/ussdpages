<?php

namespace App\Http\Controllers;

use App\Jobs\CreateUserInDatabase;
use App\Navigator;
use App\State\Registration\StateContext;
use App\User;
use App\UssdSession;
use App\UssdView;
use Hash;
use Illuminate\Http\Request;

class DisplayUssdController extends Controller
{
    public function index(Request $request)
    {
        $inputArray = explode('*', $request->input('text'));

        $session = UssdSession::firstOrCreate([
            'session_id' => $request->input('sessionId'),
            'phone_number' => $request->input('phoneNumber'),
        ]);

        if ($user = User::where('phone_number', $request->phoneNumber)->first()) {
            $session->user()->associate($user);
            $session->save();
        }

        if(! $session->user) {
            $context = new StateContext($session);
            $context->name();
        }

        if ($inputArray[0]) {
            $context->pin();
        }

        return $session->currentView->body;
    }

    public function index1(Request $request)
    {
        // Store the session
        $session = UssdSession::firstOrCreate([
            'session_id' => $request->sessionId,
            'phone_number' => $request->phoneNumber,
        ]);

        // Attach the session to a user for easier reference.
        if ($user = User::where('phone_number', $request->phoneNumber)->first()) {
            $session->user()->associate($user);
            $session->save();
        }

        // Convert text string into an array
        $textArray = explode('*', $request->text);

        // If session has a user, it means that user is registered. Display the login menu.
        if ($session->user) {
            $loginView = UssdView::where('name', 'login-prompt')->first();

            if (! $session->currentView) {
                $view = $loginView;
            } else {
                // Check if user has entered the correct PIN, and show the main menu
                if ($session->currentView->is($loginView) && Hash::check($textArray[0], $user->pin)) {
                    $view = $session->currentView->nextViews->last();
                }else if ($session->currentView->isMenu) {
                    // If the currentView is a menu, the user input determines how we should move on from here.
                    $position = last($textArray) - 1;
                    $view = $session->currentView->nextViews[$position];
                } else {
                    $view = $session->currentView->nextViews->first();
                }
            }

            $session->makeCurrentView($view);
        }

        // Check if user is registered
        if (! $session->user) {
            // If session has no current view, it means that this is the first prompt. Display the register-name view.
            $registerView = UssdView::where('name', 'register-name')->first();

            if (! $session->currentView) {
                $session->makeCurrentView($registerView);
            } else {
                // Get the next view and save it as the new current view. If there is no next view, end the session.
                $nextViews = $session->currentView->nextViews;

                if ($nextViews->isNotEmpty()) {
                    $view = $nextViews->first();
                    // If the current view is confirm-pin, it should compare the two entered PINs if they match.
                    // If they match, create user in database.
                    $confirmPinView = UssdView::where('name', 'register-confirm-pin')->first();

                    if($session->currentView->is($confirmPinView)) {
                        if ($textArray[1] != $textArray[2]) {
                            $view = $nextViews->firstWhere('name', 'register-failure');
                        } else {
                            CreateUserInDatabase::dispatchNow([
                                'name' => $textArray[0],
                                'pin' => $textArray[1],
                                'phone_number' => $request->phoneNumber
                            ]);
                        }
                    }
                    $session->currentView()->associate($view);
                    $session->save();
                }

            }


        }
        return $session->currentView->body ?? "END There was a problem displaying the view";
    }
}
