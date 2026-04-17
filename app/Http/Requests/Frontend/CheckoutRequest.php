<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:150'],
            'postal_code' => ['required', 'string', 'max:20'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
