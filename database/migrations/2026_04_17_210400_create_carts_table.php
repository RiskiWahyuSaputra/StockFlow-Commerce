<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['active', 'converted', 'abandoned'])->default('active');
            $table->char('currency', 3)->default('IDR');
            $table->unsignedInteger('total_items')->default(0);
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->timestamp('converted_at')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['status', 'expired_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
