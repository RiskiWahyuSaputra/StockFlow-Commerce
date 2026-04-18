<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class InventorySyncStockRequest extends AdminFormRequest
{
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => 'produk',
            'stock' => 'stok target',
            'note' => 'catatan',
        ];
    }
}
