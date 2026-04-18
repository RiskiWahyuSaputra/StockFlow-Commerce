<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventorySyncStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
