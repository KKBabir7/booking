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
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('type')->default('room')->after('user_id'); // room, restaurant, conference
            $table->string('title')->nullable()->after('type');
            $table->foreignId('room_id')->nullable()->change();
            $table->foreignId('hall_id')->nullable()->after('room_id')->constrained('conference_halls')->onDelete('cascade');
            $table->date('check_in')->nullable()->change();
            $table->date('check_out')->nullable()->change();
            $table->date('date')->nullable()->after('check_out'); // for restaurant/conference
            $table->string('time_slot')->nullable()->after('date');
            $table->string('duration')->nullable()->after('time_slot');
            $table->integer('guests')->nullable()->after('pets');
            $table->text('admin_notes')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['type', 'title', 'hall_id', 'date', 'time_slot', 'duration', 'guests', 'admin_notes']);
            $table->foreignId('room_id')->nullable(false)->change();
            $table->date('check_in')->nullable(false)->change();
            $table->date('check_out')->nullable(false)->change();
        });
    }
};
