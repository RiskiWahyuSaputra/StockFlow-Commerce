<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:120'],
            'sort' => ['nullable', 'string', Rule::in(['latest', 'lowest_price', 'highest_price'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
