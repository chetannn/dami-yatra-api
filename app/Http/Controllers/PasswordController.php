<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function update(Request $request)
    {
       $input =  $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string' ]
        ]);

       if(!isset($input['current_password']) || !Hash::check($input['current_password'], $request->user()->password)) {
           throw ValidationException::withMessages([
               'current_password' => 'The provided password does not match your current password.'
           ]);
       }

        $request->user()->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();

    }
}
