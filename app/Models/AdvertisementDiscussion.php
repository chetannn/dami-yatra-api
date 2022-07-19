<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdvertisementDiscussion extends Model
{
    use HasFactory;

    protected  $guarded = [];

    public function advertisement() : BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
