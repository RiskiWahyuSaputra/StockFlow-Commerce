<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('phone', 30)->nullable()->after('email');
            $table->enum('role', ['customer', 'admin'])->default('customer')->after('password');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active')->after('role');
            $table->timestamp('last_login_at')->nullable()->after('remember_token');

            $table->index(['role', 'status']);
            $table->index('phone');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['phone']);

            $table->dropColumn([
                'phone',
                'role',
                'status',
                'last_login_at',
            ]);
        });
    }
};
