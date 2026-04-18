<?php

namespace App\Http\Requests\Frontend;

class UpdateCartItemRequest extends CustomerFormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }

    public function attributes(): array
    {
        return [
            'quantity' => 'quantity',
        ];
    }
}
