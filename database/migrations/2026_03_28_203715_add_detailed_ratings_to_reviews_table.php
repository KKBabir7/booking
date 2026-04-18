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
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change(); // Allow fake reviews without a user ID
            $table->decimal('rating', 3, 2)->change(); // Support averges like 4.92

            // Detailed Ratings (1-5)
            $table->integer('cleanliness_rating')->default(5);
            $table->integer('communication_rating')->default(5);
            $table->integer('checkin_rating')->default(5);
            $table->integer('accuracy_rating')->default(5);
            $table->integer('location_rating')->default(5);
            $table->integer('value_rating')->default(5);

            // Fake Review Fields
            $table->boolean('is_fake')->default(false);
            $table->string('fake_guest_name')->nullable();
            $table->string('fake_guest_email')->nullable();
            $table->string('fake_guest_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
        });
    }
};
