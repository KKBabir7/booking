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
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('room_type')->nullable()->after('name');
            $table->decimal('old_price', 10, 2)->nullable()->after('price');
            $table->decimal('rating', 3, 1)->default(0.0)->after('badge_text');
            $table->integer('review_count')->default(0)->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['room_type', 'old_price', 'rating', 'review_count']);
        });
    }
};
