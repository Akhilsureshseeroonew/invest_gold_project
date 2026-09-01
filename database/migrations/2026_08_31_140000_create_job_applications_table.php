<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')->nullable()->constrained()->nullOnDelete();
            $table->string('job_title');            // snapshot, kept even if the opening is deleted
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('cv_path')->nullable();  // stored on the private "local" disk
            $table->string('cv_name')->nullable();  // original filename
            $table->string('status')->default('new'); // new | reviewing | shortlisted | rejected | hired
            $table->text('admin_notes')->nullable();
            $table->string('source_url')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
