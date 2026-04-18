<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends AdminFormRequest
{
    public function rules(): array
    {
        return [
            'order_status' => ['required', Rule::in([
                Order::STATUS_PENDING,
                Order::STATUS_PAID,
                Order::STATUS_PROCESSING,
                Order::STATUS_SHIPPED,
                Order::STATUS_COMPLETED,
                Order::STATUS_CANCELLED,
                Order::STATUS_REFUNDED,
            ])],
        ];
    }

    public function attributes(): array
    {
        return [
            'order_status' => 'status order',
        ];
    }
}
