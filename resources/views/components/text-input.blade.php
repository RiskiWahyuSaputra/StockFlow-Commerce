@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-brand-500 focus:outline-none focus:ring-4 focus:ring-brand-100 [.sf-dark-inner_&]:border-white/10 [.sf-dark-inner_&]:bg-white/5 [.sf-dark-inner_&]:text-white [.sf-dark-inner_&]:focus:border-brand-500 [.sf-dark-inner_&]:focus:ring-white/10']) }}>
