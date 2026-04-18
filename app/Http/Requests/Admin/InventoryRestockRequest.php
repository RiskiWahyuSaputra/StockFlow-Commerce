<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class InventoryRestockRequest extends AdminFormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'produk',
            'quantity' => 'quantity restock',
            'note' => 'catatan',
        ];
    }
}
