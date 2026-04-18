<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $blueprint) {
            $blueprint->id();
            $blueprint->string('name');
            $blueprint->decimal('advance_amount', 10, 2)->default(0);
            $blueprint->string('image')->nullable();
            $blueprint->boolean('is_active')->default(true);
            $blueprint->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
