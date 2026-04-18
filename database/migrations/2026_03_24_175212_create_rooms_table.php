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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('capacity_adults')->default(2);
            $table->integer('capacity_children')->default(0);
            $table->string('bed_type')->nullable();
            $table->integer('room_size')->nullable();
            $table->string('view_type')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_360_available')->default(false);
            $table->string('panorama_url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->string('badge_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
