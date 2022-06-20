<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    public function __invoke(Request $request) : JsonResponse
    {
         $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => ['required', 'confirmed'],
            'email' => ['required', Rule::unique('users', 'email')],
            'type' => ['required', 'between:0,1'],
        ]);

       $user = User::create(array_merge($request->only('first_name', 'last_name', 'email', 'type'),
           [
               'password' => bcrypt($request->input('password')),
               'name' => $request->input('first_name') . ' ' . $request->input('last_name')
           ]));

       if($user->type == 0) {
           $user->customer()->create([
               'first_name' => $user->first_name,
               'last_name' => $user->last_name,
               'email' => $user->email,
               'name' => $user->name,
           ]);
       }
       else if($user->type == 1) {
           $user->vendor()->create([
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'name' => $user->name,
           ]);
       }

       event(new Registered($user));

       auth()->login($user);

       return new JsonResponse($user, Response::HTTP_CREATED);

    }

}
