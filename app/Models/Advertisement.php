<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        'status'
    ];

    protected $appends = [
        'cover_image_path_url'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'ad_end_date' => 'date'
    ];

    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'advertisements_tags');
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function getCoverImagePathUrlAttribute()
    {
        return $this->cover_image_path ? Storage::disk(config('FILESYSTEM_DISK'))->url($this->cover_image_path) : null;
    }

    public function scopeWithIsFavorite(Builder $query, Customer $customer)
    {
        $query->addSelect([
            'is_favorite' => DB::table('saved_advertisements')
                            ->selectRaw('COUNT(advertisement_id) > 0')
                             ->whereColumn('advertisements.id', '=', 'advertisement_id')
                             ->where('customer_id', $customer->id)
                             ->limit(1)
        ])->withCasts(['is_favorite' => 'bool']);
    }

    public function favoritedBy() : BelongsToMany
    {
        return $this->belongsToMany(Customer::class, 'saved_advertisements', 'advertisement_id');
    }


}
