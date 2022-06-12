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

                return request()->wantsJson() ? new JsonResponse([], 204)
                    : redirect(url(env('FRONTEND_URL')) . '/app?verified=1' );
            }

            return request()->wantsJson() ? new JsonResponse([], 204)
                : redirect(url(env('FRONTEND_URL')) . '/app?verified=1' );
        }
}
