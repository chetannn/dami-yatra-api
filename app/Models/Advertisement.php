<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'is_published',
        'ad_end_date',
        'itinerary_file',
        'duration',
        'price',
        'cover_image_path',
    ];

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'advertisements_tags');
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
