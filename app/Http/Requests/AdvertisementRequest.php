<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'max:500'],
            'tags' => ['nullable', 'required_if:status,1'],
            'ad_end_date' => ['nullable', 'required_if:status,1', 'date'],
            'itinerary_file' => ['nullable', 'required_if:status,1', 'file', 'max:2048', 'mimes:docx,pdf,jpg'],
            'cover_image' => ['required', 'image', 'max:2048'],
            'duration' => ['string', 'required'],
            'price' => ['required'],
            'status' => ['required'],
            'tour_start_date' => ['required', 'date'],
            'activities' => ['nullable', 'array'],
            'meals' => ['nullable', 'array'],
            'accommodations' => ['nullable', 'array'],
            'featured' => ['required']
         ];
    }
}
