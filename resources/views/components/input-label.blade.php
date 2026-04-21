@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-slate-700 [.sf-dark-inner_&]:text-slate-300']) }}>
    {{ $value ?? $slot }}
</label>
