<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery\MockInterface;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_checkout_creates_order_order_items_reserves_stock_and_converts_cart(): void
    {
        $user = $this->createCustomer();
        $product = $this->createActiveProduct([
            'name' => 'Orbit Headphone',
            'price' => 300000,
            'stock' => 10,
        ]);

        $cart = $this->createCartWithItem($user, $product, 2);

        $this->mock(MidtransService::class, function (MockInterface $mock): void {
            $mock->shouldReceive('createSnapPayment')
                ->once()
                ->andReturnUsing(function (Order $order): Payment {
                    $order->forceFill([
                        'payment_status' => Order::PAYMENT_PENDING,
                    ])->save();

                    return new Payment([
                        'provider' => 'midtrans',
                        'method' => 'snap',
                        'payment_type' => 'snap',
                        'status' => Payment::STATUS_PENDING,
                        'amount' => 600000,
                        'gross_amount' => 600000,
                        'currency' => 'IDR',
                        'external_id' => $order->order_number,
                    ]);
                });
        });

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'recipient_name' => 'Riski Wahyu',
            'phone' => '081234567890',
            'address' => 'Jl. Test No. 123',
            'city' => 'Bandar Lampung',
            'postal_code' => '35141',
            'note' => 'Titip di security',
        ]);

        $order = Order::query()->where('user_id', $user->id)->firstOrFail();

        $response->assertRedirect(route('checkout.success', $order, absolute: false));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'order_status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_PENDING,
            'shipping_recipient_name' => 'Riski Wahyu',
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 600000,
        ]);

        $this->assertDatabaseHas('inventory_logs', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'type' => 'reserved',
            'quantity_before' => 10,
            'quantity_after' => 8,
        ]);

        $this->assertSame(8, $product->fresh()->stock);

        $this->assertDatabaseHas('carts', [
            'id' => $cart->id,
            'status' => Cart::STATUS_CONVERTED,
            'total_items' => 0,
        ]);

        $this->assertDatabaseMissing('cart_items', [
            'cart_id' => $cart->id,
        ]);
    }
}
