<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function advertisements() : HasMany
    {
        return $this->hasMany(Advertisement::class);
    }

    public function notifications() : MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function coupons() : HasMany
    {
        return $this->hasMany(Coupon::class);
    }


}
