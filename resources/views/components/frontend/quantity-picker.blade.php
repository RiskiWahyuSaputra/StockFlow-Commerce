@props([
    'name' => 'quantity',
    'value' => 1,
    'min' => 1,
    'max' => null,
    'size' => 'md',
    'id' => null,
])

@php
    $inputId = $id ?: $name.'-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(8));
    $initialValue = max((int) $min, (int) $value);

    if ($max !== null) {
        $initialValue = min($initialValue, (int) $max);
    }

    $sizes = [
        'sm' => [
            'wrapper' => 'gap-1.5 rounded-full px-1.5 py-1',
            'button' => 'h-7 w-7 text-sm',
            'value' => 'min-w-[2rem] text-sm',
        ],
        'md' => [
            'wrapper' => 'gap-2 rounded-full px-2 py-1.5',
            'button' => 'h-10 w-10 text-base',
            'value' => 'min-w-[2.75rem] text-base',
        ],
    ][$size] ?? [
        'wrapper' => 'gap-2 rounded-full px-2 py-1.5',
        'button' => 'h-10 w-10 text-base',
        'value' => 'min-w-[2.75rem] text-base',
    ];

    $maxValue = $max !== null ? (int) $max : null;
@endphp

<div
    x-data="{
        qty: {{ $initialValue }},
        min: {{ (int) $min }},
        max: {{ $maxValue ?? 'null' }},
        decrease() {
            this.qty = Math.max(this.min, this.qty - 1);
        },
        increase() {
            this.qty = this.max === null ? this.qty + 1 : Math.min(this.max, this.qty + 1);
        }
    }"
    {{ $attributes->class([
        'inline-flex items-center border border-slate-200 bg-white shadow-sm',
        $sizes['wrapper'],
    ]) }}
>
    <button
        type="button"
        x-on:click="decrease()"
        @class([
            'inline-flex items-center justify-center rounded-full border border-slate-200 bg-slate-50 font-bold leading-none text-slate-600 transition hover:border-slate-300 hover:text-slate-900 disabled:cursor-not-allowed disabled:opacity-50',
            $sizes['button'],
        ])
        :disabled="qty <= min"
        aria-label="Kurangi quantity"
    >
        &minus;
    </button>

    <span
        x-text="qty"
        @class([
            'text-center font-semibold text-slate-900',
            $sizes['value'],
        ])
    ></span>

    <input
        id="{{ $inputId }}"
        type="hidden"
        name="{{ $name }}"
        x-model="qty"
        value="{{ $initialValue }}"
    >

    <button
        type="button"
        x-on:click="increase()"
        @class([
            'inline-flex items-center justify-center rounded-full border border-slate-200 bg-slate-50 font-bold leading-none text-slate-600 transition hover:border-slate-300 hover:text-slate-900 disabled:cursor-not-allowed disabled:opacity-50',
            $sizes['button'],
        ])
        :disabled="max !== null && qty >= max"
        aria-label="Tambah quantity"
    >
        +
    </button>
</div>
