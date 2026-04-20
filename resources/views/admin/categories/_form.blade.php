@php
    $isEdit = $category->exists;
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <section class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="md:col-span-2">
                <label for="name" class="text-sm font-semibold text-slate-900">Nama Kategori</label>
                <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="slug" class="text-sm font-semibold text-slate-900">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" placeholder="Otomatis jika dikosongkan">
            </div>

            <div>
                <label for="parent_id" class="text-sm font-semibold text-slate-900">Kategori Induk</label>
                <select id="parent_id" name="parent_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <option value="">Tidak ada parent</option>
                    @foreach ($parentCategories as $parentCategory)
                        <option value="{{ $parentCategory->id }}" @selected((string) old('parent_id', $category->parent_id) === (string) $parentCategory->id)>
                            {{ $parentCategory->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="text-sm font-semibold text-slate-900">Status</label>
                <select id="status" name="status" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <option value="active" @selected(old('status', $category->status ?: 'active') === 'active')>Aktif</option>
                    <option value="inactive" @selected(old('status', $category->status) === 'inactive')>Nonaktif</option>
                </select>
            </div>

            <div>
                <label for="sort_order" class="text-sm font-semibold text-slate-900">Urutan Tampil</label>
                <input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div class="md:col-span-2">
                <label for="description" class="text-sm font-semibold text-slate-900">Deskripsi</label>
                <textarea id="description" name="description" rows="5" class="mt-2 block w-full rounded-[1.6rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">{{ old('description', $category->description) }}</textarea>
            </div>
        </div>
    </section>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            {{ $isEdit ? 'Perbarui Kategori' : 'Buat Kategori' }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
            Kembali ke Daftar
        </a>
    </div>
</form>
