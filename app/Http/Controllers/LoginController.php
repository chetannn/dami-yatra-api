<?php

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @throws AuthenticationException
     */
    public function __invoke(Request $request)
    {
        if(!auth()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException();
        }
    }
}
