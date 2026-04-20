<?php

namespace Tests\Feature;

use App\Models\InventoryLog;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\Concerns\CreatesEcommerceData;
use Tests\TestCase;

class MidtransWebhookTest extends TestCase
{
    use CreatesEcommerceData, RefreshDatabase;

    public function test_midtrans_callback_updates_payment_order_and_finalizes_inventory_log(): void
    {
        config()->set('midtrans.server_key', 'test-server-key');

        $user = $this->createCustomer();
        $product = $this->createActiveProduct([
            'stock' => 8,
            'price' => 200000,
        ]);

        $order = Order::query()->create([
            'user_id' => $user->id,
            'cart_id' => null,
            'order_number' => 'ORD-TEST-'.Str::upper(Str::random(8)),
            'order_status' => Order::STATUS_PENDING,
            'payment_status' => Order::PAYMENT_PENDING,
            'currency' => 'IDR',
            'subtotal' => 400000,
            'shipping_cost' => 0,
            'tax_amount' => 0,
            'discount_amount' => 0,
            'grand_total' => 400000,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone,
            'shipping_recipient_name' => 'Riski Wahyu',
            'shipping_phone' => '081234567890',
            'shipping_address_line1' => 'Jl. Test No. 123',
            'shipping_address_line2' => null,
            'shipping_city' => 'Bandar Lampung',
            'shipping_state' => null,
            'shipping_postal_code' => '35141',
            'shipping_country' => 'ID',
            'shipping_notes' => null,
            'notes' => null,
            'placed_at' => now(),
            'paid_at' => null,
            'cancelled_at' => null,
            'completed_at' => null,
        ]);

        OrderItem::factory()->for($order)->for($product)->create([
            'quantity' => 2,
            'unit_price' => 200000,
            'total_price' => 400000,
            'product_name' => $product->name,
            'product_slug' => $product->slug,
            'sku' => $product->sku,
        ]);

        Payment::factory()->for($order)->create([
            'external_id' => $order->order_number,
            'status' => Payment::STATUS_PENDING,
            'amount' => 400000,
            'gross_amount' => 400000,
            'transaction_status' => 'pending',
        ]);

        InventoryLog::factory()->create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'order_id' => $order->id,
            'type' => InventoryLog::TYPE_RESERVED,
            'quantity_before' => 10,
            'quantity_change' => -2,
            'quantity_changed' => -2,
            'quantity_after' => 8,
            'reference' => $order->order_number,
            'reference_type' => 'order',
            'reference_id' => $order->id,
            'notes' => 'Stock reserved saat checkout order dibuat.',
            'note' => 'Stock reserved saat checkout order dibuat.',
        ]);

        $grossAmount = number_format((float) $order->grand_total, 2, '.', '');

        $payload = [
            'order_id' => $order->order_number,
            'status_code' => '200',
            'gross_amount' => $grossAmount,
            'transaction_status' => 'settlement',
            'payment_type' => 'bank_transfer',
            'transaction_id' => 'TRX-WEBHOOK-001',
            'fraud_status' => 'accept',
            'transaction_time' => now()->format('Y-m-d H:i:s'),
            'signature_key' => hash('sha512', $order->order_number.'200'.$grossAmount.'test-server-key'),
        ];

        $response = $this->postJson(route('payments.midtrans.notification'), $payload);

        $response->assertOk()
            ->assertJson([
                'received' => true,
                'payment_status' => Payment::STATUS_PAID,
            ]);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
            'transaction_id' => 'TRX-WEBHOOK-001',
            'transaction_status' => 'settlement',
            'status' => Payment::STATUS_PAID,
        ]);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => Order::STATUS_PAID,
            'payment_status' => Order::PAYMENT_PAID,
        ]);

        $this->assertDatabaseHas('inventory_logs', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'type' => InventoryLog::TYPE_DEDUCTED,
            'quantity_before' => 8,
            'quantity_after' => 8,
        ]);

        $this->assertSame(8, $product->fresh()->stock);
    }
}
