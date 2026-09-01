<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('icon')->nullable()->after('template');       // sprite id for cards / hero
            $table->json('stats')->nullable()->after('highlights');       // [{value,label}]
            $table->string('cta_heading')->nullable()->after('extra_html');
            $table->text('cta_text')->nullable()->after('cta_heading');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['icon', 'stats', 'cta_heading', 'cta_text']);
        });
    }
};
