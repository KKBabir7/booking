<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('status');
            }
            if (!Schema::hasColumn('bookings', 'amount_paid')) {
                $table->decimal('amount_paid', 10, 2)->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('bookings', 'payment_percentage')) {
                $table->integer('payment_percentage')->default(100)->after('amount_paid');
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('payment_percentage');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columns = ['transaction_id', 'payment_status', 'amount_paid', 'payment_percentage', 'payment_method'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
