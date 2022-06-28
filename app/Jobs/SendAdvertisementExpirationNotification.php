<?php

namespace App\Jobs;

use App\Mail\AdvertisementExpiration;
use App\Models\Advertisement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdvertisementExpirationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Advertisement::query()
            ->where('status', 1)
            ->whereDate('ad_end_date', now()->addDays(5))
            ->chunk(50, function ($advertisements) {
            foreach ($advertisements as $advertisement) {
                Mail::to($advertisement->vendor->email)->send(new AdvertisementExpiration());
            }
        });




    }
}
