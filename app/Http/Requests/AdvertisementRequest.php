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
            'is_published' => ['boolean', 'required'],
            'ad_end_date' => ['nullable', 'required_if:is_published,1', 'date'],
            'itinerary_file' => ['nullable', 'file', 'max:2048', 'mimes:docx,pdf,jpg'],
            'duration' => ['string', 'required'],
            'price' => ['required']
         ];
    }
}
