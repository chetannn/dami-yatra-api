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
            'title' => 'required',
            'description' => ['required', 'max:200'],
            'tags' => 'required',
            'tags.*' => ['required'],
            'ad_end_date' => ['nullable', 'required_if:is_published,1', 'date'],
            'itinerary_file' => ['nullable', 'file', 'max:2048', 'mimes:docx,pdf,jpg'],
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
