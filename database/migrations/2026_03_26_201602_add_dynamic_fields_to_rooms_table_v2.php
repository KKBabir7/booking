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
            if (!Schema::hasColumn('rooms', 'slug')) {
                $table->string('slug')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('rooms', 'amenities')) {
                $table->json('amenities')->nullable()->after('review_count');
            }
            if (!Schema::hasColumn('rooms', 'rules')) {
                $table->json('rules')->nullable()->after('amenities');
            }
            if (!Schema::hasColumn('rooms', 'faqs')) {
                $table->json('faqs')->nullable()->after('rules');
            }
            if (!Schema::hasColumn('rooms', 'gallery_images')) {
                $table->json('gallery_images')->nullable()->after('faqs');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn(['slug', 'amenities', 'rules', 'faqs', 'gallery_images']);
        });
    }
};
