<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request) : JsonResponse
    {
        $request->validate(['email' => 'required|email']);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = $this->broker()->sendResetLink(
            $request->only('email')
        );

            return new JsonResponse($status == Password::RESET_LINK_SENT);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker('users');
    }
}
