<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class UpdateProfileController extends Controller
{
    public function __invoke() : JsonResponse
    {
        request()->validate([
            'name' => 'required',
             'mobile' => ['required', 'string', 'digits:10']
//            'first_name' => 'required_if:type,0',
//            'last_name' => 'required_if:type,0',
        ]);

        auth()->user()->update(request()->only('name'));

        return new JsonResponse([]);
    }
}
