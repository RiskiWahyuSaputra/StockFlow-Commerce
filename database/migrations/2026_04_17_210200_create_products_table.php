<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku', 100)->unique();
            $table->string('short_description', 500)->nullable();
            $table->longText('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedInteger('low_stock_threshold')->default(5);
            $table->unsignedInteger('weight')->nullable()->comment('Weight in grams');
            $table->boolean('track_stock')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'active', 'inactive', 'archived'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'status']);
            $table->index(['status', 'is_featured']);
            $table->index(['price']);
            $table->index(['stock']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
