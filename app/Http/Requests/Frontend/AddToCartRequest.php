<?php

namespace App\Http\Requests\Frontend;

use App\Models\Product;
use Illuminate\Validation\Rule;

class AddToCartRequest extends CustomerFormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')->where(fn ($query) => $query->where('status', Product::STATUS_ACTIVE)),
            ],
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'intent' => ['nullable', 'string', Rule::in(['checkout'])],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'produk',
            'quantity' => 'quantity',
            'intent' => 'aksi',
        ];
    }
}
