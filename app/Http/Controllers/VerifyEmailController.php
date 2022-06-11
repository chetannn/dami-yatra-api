<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function __invoke($id)
    {
            $user = User::findOrFail($id);

            if (!$user->hasVerifiedEmail()) {

                $user->markEmailAsVerified();
                event(new Verified($user));

                request()->wantsJson() ? new JsonResponse([], 204)
                    : redirect(url(env('FRONTEND_URL')) . '/customer?verified=1' );
            }

            request()->wantsJson() ? new JsonResponse([], 204)
                : redirect(url(env('FRONTEND_URL')) . '/customer?verified=1' );
        }
}
