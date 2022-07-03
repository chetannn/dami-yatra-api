<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class KhaltiGateway
{
    public function verify($token, $amount) : bool
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.khalti.secret'),
        ])->post(config('services.khalti.url'), [
            'token' => $token,
            'amount' => $amount
        ]);

        logger($response->json());

        return $response->successful();
    }
}
