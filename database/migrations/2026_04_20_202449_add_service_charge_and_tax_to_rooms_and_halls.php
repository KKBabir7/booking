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
            $table->decimal('service_charge', 12, 2)->nullable()->default(0)->after('price');
            $table->decimal('tax', 12, 2)->nullable()->default(0)->after('service_charge');
        });

        Schema::table('conference_halls', function (Blueprint $table) {
            $table->decimal('service_charge', 12, 2)->nullable()->default(0)->after('price');
            $table->decimal('tax', 12, 2)->nullable()->default(0)->after('service_charge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['service_charge', 'tax']);
        });

        Schema::table('conference_halls', function (Blueprint $table) {
            $table->dropColumn(['service_charge', 'tax']);
        });
    }
};
