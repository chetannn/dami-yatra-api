<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{

    /**
     * Send a new email verification notification.
     *
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request) : RedirectResponse|JsonResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
//            return $request->wantsJson()
                return new JsonResponse('', 204);
//                : redirect()->intended(Fortify::redirects('email-verification'));
        }

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse('', 202)
            : back()->with('status', 'verification-link-sent');
    }
}
