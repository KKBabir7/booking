<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index();       // e.g. 'rooms'
            $table->string('key');                  // e.g. 'banner_title'
            $table->text('value')->nullable();      // value
            $table->timestamps();
            $table->unique(['page', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_settings');
    }
};
