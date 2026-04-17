<?php

namespace App\Http\Requests\Frontend;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(fn ($query) => $query->where('status', Product::STATUS_ACTIVE)),
            ],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ];
    }
}
