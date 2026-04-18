<?php

namespace App\Http\Requests\Frontend;

class CheckoutRequest extends CustomerFormRequest
{
    public function rules(): array
    {
        return [
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\\-\\s()]+$/'],
            'address' => ['required', 'string', 'max:500'],
            'city' => ['required', 'string', 'max:150'],
            'postal_code' => ['required', 'string', 'max:20', 'regex:/^[0-9\\-]+$/'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'recipient_name' => 'nama penerima',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'city' => 'kota',
            'postal_code' => 'kode pos',
            'note' => 'catatan',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka dan karakter telepon umum.',
            'postal_code.regex' => 'Kode pos hanya boleh berisi angka atau tanda hubung.',
        ];
    }
}
