@extends('layouts.admin')

@section('title', 'Categories')
@section('heading', 'Category Management')

@section('content')
    <section class="rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Catalog Structure</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Kelola kategori produk</h2>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="flex gap-3">
                    <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari kategori..." class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <button type="submit" class="rounded-full border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                        Search
                    </button>
                </form>

                <a href="{{ route('admin.categories.create') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Create Category
                </a>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-[1.6rem] border border-slate-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-4 font-semibold">Name</th>
                            <th class="px-4 py-4 font-semibold">Parent</th>
                            <th class="px-4 py-4 font-semibold">Products</th>
                            <th class="px-4 py-4 font-semibold">Status</th>
                            <th class="px-4 py-4 font-semibold">Sort</th>
                            <th class="px-4 py-4 font-semibold">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($categories as $category)
                            <tr>
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-900">{{ $category->name }}</p>
                                    <p class="mt-1 text-xs text-slate-500">{{ $category->slug }}</p>
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $category->parent?->name ?? '-' }}</td>
                                <td class="px-4 py-4 font-semibold text-slate-900">{{ $category->products_count }}</td>
                                <td class="px-4 py-4">
                                    <x-admin.badge :value="$category->status" :classes="$category->status === 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-700'" />
                                </td>
                                <td class="px-4 py-4 text-slate-600">{{ $category->sort_order }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-full bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Belum ada kategori yang tersimpan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $categories->onEachSide(1)->links() }}
        </div>
    </section>
@endsection
