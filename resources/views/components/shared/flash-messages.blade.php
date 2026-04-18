@php
    $successMessage = session('status');
    $errorMessage = session('error');
    $validationErrors = $errors->all();
@endphp

@if ($successMessage || $errorMessage || $errors->any())
    <div class="{{ $attributes->get('class') }}">
        @if ($successMessage)
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 shadow-sm">
                {{ $successMessage }}
            </div>
        @endif

        @if ($errorMessage)
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700 shadow-sm">
                {{ $errorMessage }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700 shadow-sm">
                <p class="font-semibold">Ada beberapa hal yang perlu diperbaiki.</p>

                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach (array_slice($validationErrors, 0, 3) as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>

                @if (count($validationErrors) > 3)
                    <p class="mt-2 text-xs font-medium text-rose-600">
                        +{{ count($validationErrors) - 3 }} error lain masih perlu dicek.
                    </p>
                @endif
            </div>
        @endif
    </div>
@endif
