<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('banner_image')->nullable()->after('cover_image');
            $table->string('cta_label')->nullable()->after('read_time');
            $table->string('cta_url')->nullable()->after('cta_label');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['banner_image', 'cta_label', 'cta_url']);
        });
    }
};
