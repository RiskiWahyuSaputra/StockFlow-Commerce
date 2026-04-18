<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;

class CustomerOrderService
{
    public function getUserOrderByNumber(User $user, string $orderNumber): Order
    {
        return $user->orders()
            ->where('order_number', $orderNumber)
            ->with([
                'items' => fn (Builder $query) => $query->orderBy('id'),
                'latestPayment',
                'payments' => fn (Builder $query) => $query->latest('id'),
            ])
            ->firstOrFail();
    }

    public function getUserOrderById(User $user, int $orderId): Order
    {
        return $user->orders()
            ->whereKey($orderId)
            ->with([
                'items' => fn (Builder $query) => $query->orderBy('id'),
                'latestPayment',
                'payments' => fn (Builder $query) => $query->latest('id'),
            ])
            ->firstOrFail();
    }
}
