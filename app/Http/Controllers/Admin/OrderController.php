<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\AdminOrderService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        protected AdminOrderService $adminOrderService,
    ) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $status = trim((string) $request->query('status', ''));

        $orders = Order::query()
            ->with([
                'user:id,name',
                'latestPayment' => fn (Builder $query) => $query->select([
                    'payments.id',
                    'payments.order_id',
                    'payments.status',
                    'payments.payment_type',
                    'payments.transaction_status',
                ]),
            ])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('order_number', 'like', '%'.$search.'%')
                        ->orWhere('customer_name', 'like', '%'.$search.'%')
                        ->orWhere('customer_email', 'like', '%'.$search.'%');
                });
            })
            ->when($status !== '', fn ($query) => $query->where('order_status', $status))
            ->latest('placed_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => [
                'search' => $search,
                'status' => $status,
            ],
            'statusOptions' => [
                Order::STATUS_PENDING => 'Menunggu',
                Order::STATUS_PAID => 'Dibayar',
                Order::STATUS_PROCESSING => 'Diproses',
                Order::STATUS_SHIPPED => 'Dikirim',
                Order::STATUS_COMPLETED => 'Selesai',
                Order::STATUS_CANCELLED => 'Dibatalkan',
                Order::STATUS_REFUNDED => 'Dikembalikan',
            ],
        ]);
    }

    public function show(Order $order): View
    {
        return view('admin.orders.show', [
            'order' => $order->load([
                'user',
                'items.product',
                'payments',
                'inventoryLogs.product',
            ]),
            'statusOptions' => [
                Order::STATUS_PENDING => 'Menunggu',
                Order::STATUS_PAID => 'Dibayar',
                Order::STATUS_PROCESSING => 'Diproses',
                Order::STATUS_SHIPPED => 'Dikirim',
                Order::STATUS_COMPLETED => 'Selesai',
                Order::STATUS_CANCELLED => 'Dibatalkan',
                Order::STATUS_REFUNDED => 'Dikembalikan',
            ],
        ]);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $order = $this->adminOrderService->updateStatus(
            $order,
            $request->validated('order_status'),
            $request->user(),
        );

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Status order berhasil diperbarui.');
    }
}
