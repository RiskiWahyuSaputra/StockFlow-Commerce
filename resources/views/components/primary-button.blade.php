<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2']) }}>
    {{ $slot }}
</button>
