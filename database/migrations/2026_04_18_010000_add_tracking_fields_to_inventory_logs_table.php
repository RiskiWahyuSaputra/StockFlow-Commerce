<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table): void {
            $table->integer('quantity_changed')->nullable()->after('quantity_change');
            $table->string('reference_type')->nullable()->after('order_id');
            $table->unsignedBigInteger('reference_id')->nullable()->after('reference_type');
            $table->text('note')->nullable()->after('notes');

            $table->index(['reference_type', 'reference_id']);
        });

        DB::statement("
            UPDATE inventory_logs
            SET
                quantity_changed = quantity_change,
                note = notes,
                reference_type = CASE
                    WHEN order_id IS NOT NULL THEN 'order'
                    ELSE NULL
                END,
                reference_id = order_id
        ");
    }

    public function down(): void
    {
        Schema::table('inventory_logs', function (Blueprint $table): void {
            $table->dropIndex(['reference_type', 'reference_id']);
            $table->dropColumn([
                'quantity_changed',
                'reference_type',
                'reference_id',
                'note',
            ]);
        });
    }
};
