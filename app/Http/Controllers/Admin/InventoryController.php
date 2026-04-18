<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\InventoryRestockRequest;
use App\Http\Requests\Admin\InventorySyncStockRequest;
use App\Models\InventoryLog;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService,
    ) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $type = trim((string) $request->query('type', ''));

        $logs = InventoryLog::query()
            ->with([
                'product:id,name,sku,stock',
                'user:id,name',
                'order:id,order_number',
            ])
            ->when($search !== '', function ($query) use ($search): void {
                $query->whereHas('product', function ($productQuery) use ($search): void {
                    $productQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('sku', 'like', '%'.$search.'%');
                });
            })
            ->when($type !== '', fn ($query) => $query->where('type', $type))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $products = Product::query()
            ->select(['id', 'name', 'sku', 'stock'])
            ->orderBy('name')
            ->get();

        return view('admin.inventory.index', [
            'logs' => $logs,
            'products' => $products,
            'filters' => [
                'search' => $search,
                'type' => $type,
            ],
            'typeOptions' => [
                InventoryLog::TYPE_INITIAL => 'Initial',
                InventoryLog::TYPE_RESTOCK => 'Restock',
                InventoryLog::TYPE_ADJUSTMENT => 'Adjustment',
                InventoryLog::TYPE_RESERVED => 'Reserved',
                InventoryLog::TYPE_DEDUCTED => 'Deducted',
                InventoryLog::TYPE_RELEASED => 'Released',
                InventoryLog::TYPE_RETURNED => 'Returned',
            ],
            'summary' => [
                'total_logs' => InventoryLog::query()->count(),
                'restock_logs' => InventoryLog::query()->where('type', InventoryLog::TYPE_RESTOCK)->count(),
                'reserved_logs' => InventoryLog::query()->where('type', InventoryLog::TYPE_RESERVED)->count(),
                'low_stock_products' => Product::query()
                    ->whereColumn('stock', '<=', 'low_stock_threshold')
                    ->count(),
            ],
        ]);
    }

    public function restock(InventoryRestockRequest $request): RedirectResponse
    {
        $this->inventoryService->restock(
            (int) $request->validated('product_id'),
            (int) $request->validated('quantity'),
            $request->user(),
            $request->validated('note'),
        );

        return redirect()
            ->route('admin.inventory.index')
            ->with('status', 'Restock stok berhasil disimpan dan inventory log sudah tercatat.');
    }

    public function syncStock(InventorySyncStockRequest $request): RedirectResponse
    {
        $this->inventoryService->syncStock(
            (int) $request->validated('product_id'),
            (int) $request->validated('stock'),
            $request->user(),
            $request->validated('note'),
        );

        return redirect()
            ->route('admin.inventory.index')
            ->with('status', 'Sinkronisasi stok berhasil disimpan dan inventory log sudah tercatat.');
    }
}
