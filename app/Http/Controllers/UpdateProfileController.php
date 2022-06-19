<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UpdateProfileController extends Controller
{
    public function __invoke() : JsonResponse
    {
        request()->validate([
            'name' => ['required', 'string'],
             'mobile' => ['nullable', 'string', 'digits:10'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048']
        ]);

        auth()->user()->update([
            'name' => request()->input('name'),
        ]);

        if(request()->hasFile('profile_picture')) {

            $user = auth()->user();

            if($user->profile_picture) {
                if(Storage::exists($user->profile_picture)) {
                    Storage::delete($user->profile_picture);
                }
            }

            $path = Storage::putFile('profile_pictures/' . auth()->id(), request()->file('profile_picture'));

            auth()->user()->update([
                'profile_picture' => $path
            ]);

        }

        return new JsonResponse(User::find(auth()->id()));
    }
}
