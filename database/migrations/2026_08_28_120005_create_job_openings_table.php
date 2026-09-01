<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * "job_openings" (not "jobs" — that name is taken by Laravel's queue table).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_openings', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('employment_type')->nullable();   // Full-time, Contract...
            $table->string('experience')->nullable();         // "2-4 years"
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->json('responsibilities')->nullable();     // ["...", "..."]
            $table->json('requirements')->nullable();         // ["...", "..."]
            $table->boolean('is_open')->default(true);
            $table->date('posted_at')->nullable();
            $table->date('closing_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_openings');
    }
};
