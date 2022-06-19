<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasProfilePhoto
{
    public function getProfilePictureUrlAttribute()
    {
        return $this->profile_picture
            ? Storage::disk(config('FILESYSTEM_DISK'))->url($this->profile_picture)
            : $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->name))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }
}
