@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Halaman" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-slate-500">
            Menampilkan
            <span class="font-semibold text-slate-900">{{ $paginator->firstItem() }}</span>
            sampai
            <span class="font-semibold text-slate-900">{{ $paginator->lastItem() }}</span>
            dari
            <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span>
            hasil
        </div>

        <div class="flex flex-wrap items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Sebelumnya
                </a>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex items-center rounded-full border border-transparent px-3 py-2 text-sm font-medium text-slate-400">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page" class="inline-flex min-w-11 items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-slate-900/10">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="inline-flex min-w-11 items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex items-center rounded-full border border-slate-200 bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-400">
                    Berikutnya
                </span>
            @endif
        </div>
    </nav>
@endif
