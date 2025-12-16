<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users','email')->ignore($this->user),
            ],
            'password' => $this->isMethod('post')
                ? 'required|min:6'
                : 'nullable|min:6',
            // 'roles' => 'required|array',
            // 'roles.*' => 'exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid email address.',
            'password' => 'required|min:6',
        ];
    }

}
