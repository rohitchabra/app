<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Determine the customer id when updating.
        $customer = $this->route('customer');
        $customerId = null;
        if ($customer) {
            // $customer may be a model or an id depending on route-model-binding
            $customerId = is_object($customer) ? $customer->id : $customer;
        }

        return [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                // unique, but ignore current id when updating
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'phone' => ['required', 'string', 'max:20', 'digits:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'  => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid email address.',
            'phone.required' => 'Phone is required.',
        ];
    }
}

