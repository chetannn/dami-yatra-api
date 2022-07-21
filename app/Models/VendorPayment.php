<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function advertisement() : BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

}
