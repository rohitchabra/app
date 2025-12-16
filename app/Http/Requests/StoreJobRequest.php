<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow everyone for now
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'title'       => 'required|string|max:50',
            'description' => 'nullable|string',
            'photos.*'    => 'nullable|image|max:5120',
        ];
    }

    public function messages()
    {
        return [
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists'   => 'Selected customer is invalid.',

            'title.required'       => 'Job title is required.',
            'title.max'            => 'Job title cannot be more than 50 characters.',

            'photos.*.image'       => 'Each file must be an image.',
            'photos.*.max'         => 'Image size must not exceed 5MB.',
        ];
    }
}

