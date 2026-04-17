<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $amount = fake()->numberBetween(100000, 2500000);

        return [
            'order_id' => Order::factory(),
            'provider' => 'midtrans',
            'method' => fake()->randomElement(['bank_transfer', 'qris', 'gopay']),
            'status' => Payment::STATUS_PENDING,
            'amount' => $amount,
            'currency' => 'IDR',
            'external_id' => 'MID-'.Str::upper(fake()->bothify('??###??')),
            'transaction_id' => 'TRX-'.Str::upper(fake()->unique()->bothify('??###??')),
            'snap_token' => Str::random(32),
            'snap_redirect_url' => 'https://app.sandbox.midtrans.com/snap/v4/redirection/'.Str::random(18),
            'transaction_time' => now()->subMinutes(fake()->numberBetween(5, 120)),
            'paid_at' => null,
            'expired_at' => now()->addHours(24),
            'failure_code' => null,
            'failure_message' => null,
            'payload' => [
                'transaction_status' => 'pending',
            ],
        ];
    }
}
