<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Flat key/value store for site-wide settings. Read through App\Support\Settings,
 * which caches the whole table and overrides config('site.*') at boot so views
 * keep reading config unchanged. Edited via the Filament "Site Settings" page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('site');   // site | calculator | social ...
            $table->string('key');
            $table->text('value')->nullable();          // JSON-encoded
            $table->timestamps();

            $table->unique(['group', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
