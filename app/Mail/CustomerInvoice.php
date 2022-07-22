<?php

namespace App\Mail;

use App\Models\CustomerPayment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerInvoice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Authenticatable|User $user, public CustomerPayment $customerPayment)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Order Placed')
            ->view('customer.invoice')
            ->with([
                'user' => $this->user,
                'payment' => $this->customerPayment
            ]);
    }
}
