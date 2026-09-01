<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('card_tag')->nullable()->after('icon');   // badge on overview cards ("Secured", "Popular")
            $table->boolean('featured')->default(false)->after('card_tag');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['card_tag', 'featured']);
        });
    }
};
