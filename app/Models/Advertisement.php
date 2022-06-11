<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Advertisement extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tags() : MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
