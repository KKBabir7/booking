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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_checked')->default(false)->after('role');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('is_checked')->default(false)->after('status');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->boolean('is_checked')->default(false)->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_checked');
        });

        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('is_checked');
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn('is_checked');
        });
    }
};
