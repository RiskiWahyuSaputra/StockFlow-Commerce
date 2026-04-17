<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', [
                'initial',
                'restock',
                'adjustment',
                'reserved',
                'released',
                'deducted',
                'returned',
            ]);
            $table->unsignedInteger('quantity_before');
            $table->integer('quantity_change');
            $table->unsignedInteger('quantity_after');
            $table->string('reference')->nullable();
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'created_at']);
            $table->index(['product_id', 'type']);
            $table->index(['order_id']);
            $table->index(['user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
