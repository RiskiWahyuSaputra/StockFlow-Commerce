<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('provider')->default('midtrans');
            $table->string('method')->nullable();
            $table->enum('status', [
                'pending',
                'paid',
                'failed',
                'expired',
                'cancelled',
                'refunded',
            ])->default('pending');
            $table->decimal('amount', 12, 2);
            $table->char('currency', 3)->default('IDR');
            $table->string('external_id')->nullable();
            $table->string('transaction_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->text('snap_redirect_url')->nullable();
            $table->timestamp('transaction_time')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->string('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            $table->json('payload')->nullable();
            $table->timestamps();

            $table->index(['order_id', 'status']);
            $table->index(['provider', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
