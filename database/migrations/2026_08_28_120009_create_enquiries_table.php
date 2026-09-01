<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('service')->nullable();
            $table->text('message')->nullable();
            $table->string('source_url')->nullable();     // page the form was submitted from
            $table->string('page_context')->nullable();   // e.g. "Gold Loan" prefill
            $table->string('status')->default('new');      // new | contacted | closed
            $table->text('admin_notes')->nullable();
            $table->string('ip', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enquiries');
    }
};
