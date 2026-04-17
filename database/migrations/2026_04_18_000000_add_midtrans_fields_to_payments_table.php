<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->string('payment_type')->nullable()->after('method');
            $table->decimal('gross_amount', 12, 2)->nullable()->after('amount');
            $table->string('transaction_status')->nullable()->after('transaction_id');
            $table->string('fraud_status')->nullable()->after('transaction_status');
            $table->string('status_code')->nullable()->after('fraud_status');
            $table->string('signature_key')->nullable()->after('status_code');

            $table->index(['external_id', 'transaction_status']);
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table): void {
            $table->dropIndex(['external_id', 'transaction_status']);
            $table->dropColumn([
                'payment_type',
                'gross_amount',
                'transaction_status',
                'fraud_status',
                'status_code',
                'signature_key',
            ]);
        });
    }
};
