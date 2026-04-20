<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CustomerOrderService;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderHistoryController extends Controller
{
    public function __construct(
        protected CustomerOrderService $customerOrderService,
    ) {}

    public function index(Request $request): View
    {
        $ordersQuery = $request->user()->orders();

        $orders = (clone $ordersQuery)
            ->select([
                'id',
                'user_id',
                'order_number',
                'order_status',
                'payment_status',
                'grand_total',
                'shipping_recipient_name',
                'placed_at',
                'paid_at',
            ])
            ->with([
                'items:id,order_id,product_name,quantity',
                'latestPayment' => fn (Builder $query) => $query->select([
                    'payments.id',
                    'payments.order_id',
                    'payments.payment_type',
                    'payments.transaction_status',
                    'payments.status',
                    'payments.transaction_id',
                ]),
            ])
            ->orderByDesc('placed_at')
            ->orderByDesc('id')
            ->paginate(8);

        $summary = [
            'total_orders' => (clone $ordersQuery)->count(),
            'pending_payment' => (clone $ordersQuery)
                ->whereIn('payment_status', [Order::PAYMENT_UNPAID, Order::PAYMENT_PENDING])
                ->count(),
            'completed_orders' => (clone $ordersQuery)
                ->where('order_status', Order::STATUS_COMPLETED)
                ->count(),
            'total_spent' => (clone $ordersQuery)
                ->where('payment_status', Order::PAYMENT_PAID)
                ->sum('grand_total'),
        ];

        return view('frontend.orders.index', [
            'orders' => $orders,
            'summary' => $summary,
        ]);
    }

    public function show(Request $request, string $orderNumber): View
    {
        return view('frontend.orders.show', [
            'order' => $this->resolveUserOrder($request, $orderNumber),
        ]);
    }

    public function resolveUserOrder(Request $request, string $orderNumber): Order
    {
        return $this->customerOrderService->getUserOrderByNumber($request->user(), $orderNumber);
    }
}
