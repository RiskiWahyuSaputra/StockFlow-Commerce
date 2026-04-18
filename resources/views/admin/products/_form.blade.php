@php
    $isEdit = $product->exists;
    $statusValue = old('status', $product->status ?: 'draft');
@endphp

<form method="POST" action="{{ $isEdit ? route('admin.products.update', $product) : route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <section class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="grid gap-4 lg:grid-cols-2">
            <div class="lg:col-span-2">
                <label for="name" class="text-sm font-semibold text-slate-900">Product Name</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="slug" class="text-sm font-semibold text-slate-900">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $product->slug) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" placeholder="Otomatis jika dikosongkan">
            </div>

            <div>
                <label for="sku" class="text-sm font-semibold text-slate-900">SKU</label>
                <input id="sku" type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="category_id" class="text-sm font-semibold text-slate-900">Category</label>
                <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <option value="">Tanpa kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="text-sm font-semibold text-slate-900">Status</label>
                <select id="status" name="status" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
                    <option value="draft" @selected($statusValue === 'draft')>Draft</option>
                    <option value="active" @selected($statusValue === 'active')>Active</option>
                    <option value="inactive" @selected($statusValue === 'inactive')>Inactive</option>
                    <option value="archived" @selected($statusValue === 'archived')>Archived</option>
                </select>
            </div>

            <div>
                <label for="price" class="text-sm font-semibold text-slate-900">Price</label>
                <input id="price" type="number" min="0" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="stock" class="text-sm font-semibold text-slate-900">Stock</label>
                <input id="stock" type="number" min="0" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="low_stock_threshold" class="text-sm font-semibold text-slate-900">Low Stock Threshold</label>
                <input id="low_stock_threshold" type="number" min="0" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 5) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0" required>
            </div>

            <div>
                <label for="weight" class="text-sm font-semibold text-slate-900">Weight (gram)</label>
                <input id="weight" type="number" min="0" name="weight" value="{{ old('weight', $product->weight) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
            </div>

            <div>
                <label for="published_at" class="text-sm font-semibold text-slate-900">Published At</label>
                <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', optional($product->published_at)->format('Y-m-d\TH:i')) }}" class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">
            </div>

            <div class="lg:col-span-2">
                <label for="short_description" class="text-sm font-semibold text-slate-900">Short Description</label>
                <textarea id="short_description" name="short_description" rows="3" class="mt-2 block w-full rounded-[1.4rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div class="lg:col-span-2">
                <label for="description" class="text-sm font-semibold text-slate-900">Description</label>
                <textarea id="description" name="description" rows="8" class="mt-2 block w-full rounded-[1.4rem] border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-slate-400 focus:outline-none focus:ring-0">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="lg:col-span-2 flex flex-wrap gap-6">
                <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                    <input type="hidden" name="track_stock" value="0">
                    <input type="checkbox" name="track_stock" value="1" @checked(old('track_stock', $product->track_stock ?? true)) class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-400">
                    Track Stock
                </label>

                <label class="inline-flex items-center gap-3 text-sm font-semibold text-slate-700">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false)) class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-400">
                    Featured Product
                </label>
            </div>
        </div>
    </section>

    <section class="rounded-[1.8rem] border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-400">Product Images</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-slate-950">Upload beberapa gambar produk</h3>
            </div>
            <p class="text-sm text-slate-500">Format: JPG, PNG, WEBP. Maks 4MB per file.</p>
        </div>

        <div class="mt-6">
            <label for="images" class="text-sm font-semibold text-slate-900">Upload Images</label>
            <input id="images" type="file" name="images[]" multiple class="mt-2 block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-slate-900 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white">
        </div>

        @if ($isEdit && $product->images->isNotEmpty())
            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ($product->images as $image)
                    <label class="overflow-hidden rounded-[1.6rem] border border-slate-200 bg-slate-50">
                        <div class="aspect-[4/3] overflow-hidden bg-slate-100">
                            <img src="{{ $image->image_url }}" alt="{{ $image->alt_text ?? $product->name }}" class="h-full w-full object-cover">
                        </div>
                        <div class="space-y-3 p-4">
                            <label class="flex items-center gap-3 text-sm font-medium text-slate-700">
                                <input type="radio" name="primary_image_id" value="{{ $image->id }}" @checked((string) old('primary_image_id', $product->primaryImage?->id) === (string) $image->id) class="border-slate-300 text-slate-900 shadow-sm focus:ring-slate-400">
                                Jadikan primary image
                            </label>
                            <label class="flex items-center gap-3 text-sm font-medium text-rose-700">
                                <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}" class="rounded border-rose-300 text-rose-600 shadow-sm focus:ring-rose-400">
                                Hapus gambar ini
                            </label>
                        </div>
                    </label>
                @endforeach
            </div>
        @endif
    </section>

    <div class="flex flex-wrap items-center gap-3">
        <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
            {{ $isEdit ? 'Update Product' : 'Create Product' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900">
            Back to List
        </a>
    </div>
</form>
