<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifications() : MorphMany
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    public function savedAdvertisements() : BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'saved_advertisements');
    }

    public function views() : BelongsToMany
    {
        return $this->belongsToMany(Advertisement::class, 'advertisement_customer_views');
    }

    public function payments() : HasMany
    {
        return $this->hasMany(CustomerPayment::class);
    }

    public function discussions() : HasMany
    {
        return $this->hasMany(AdvertisementDiscussion::class);
    }


}
