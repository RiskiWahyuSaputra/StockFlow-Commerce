<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('cart_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_number')->unique();
            $table->enum('order_status', [
                'pending',
                'paid',
                'processing',
                'shipped',
                'completed',
                'cancelled',
                'refunded',
            ])->default('pending');
            $table->enum('payment_status', [
                'unpaid',
                'pending',
                'paid',
                'failed',
                'expired',
                'refunded',
            ])->default('unpaid');
            $table->char('currency', 3)->default('IDR');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('shipping_cost', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone', 30);
            $table->string('shipping_recipient_name');
            $table->string('shipping_phone', 30);
            $table->string('shipping_address_line1');
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_city');
            $table->string('shipping_state')->nullable();
            $table->string('shipping_postal_code', 20)->nullable();
            $table->char('shipping_country', 2)->default('ID');
            $table->text('shipping_notes')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('placed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'order_status']);
            $table->index(['payment_status', 'order_status']);
            $table->index(['placed_at']);
            $table->index(['customer_email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
