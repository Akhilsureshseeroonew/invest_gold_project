<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->string('event_time')->nullable()->after('event_date');   // "10:00 AM – 4:00 PM"
            $table->string('organizer')->nullable()->after('location');
            $table->json('gallery')->nullable()->after('body');              // [{image, caption}]
            $table->string('cta_label')->nullable()->after('source_url');
            $table->string('cta_url')->nullable()->after('cta_label');
        });
    }

    public function down(): void
    {
        Schema::table('news_items', function (Blueprint $table) {
            $table->dropColumn(['event_time', 'organizer', 'gallery', 'cta_label', 'cta_url']);
        });
    }
};
