<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('payment_settings', 'group')) {
            Schema::table('payment_settings', function (Blueprint $table) {
                $table->string('group')->nullable()->after('value');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
};
