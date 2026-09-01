<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();           // 'home', 'about', 'products/gold-loan'
            $table->string('template')->default('standard');
            $table->string('title');                    // H1 / page title
            $table->string('menu_label')->nullable();

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->string('og_image')->nullable();

            // Hero band
            $table->string('hero_eyebrow')->nullable();
            $table->string('hero_heading')->nullable();  // may contain <span class="gold-text">
            $table->text('hero_lead')->nullable();
            $table->json('hero_ctas')->nullable();       // [{label,url,style}]

            // Body + structured blocks (hybrid model)
            $table->longText('body')->nullable();        // rich text
            $table->json('features')->nullable();        // ["...", "..."]  check list
            $table->json('steps')->nullable();           // ["...", "..."]  how-it-works
            $table->json('highlights')->nullable();      // [{icon,title,text}] glance cards
            $table->longText('extra_html')->nullable();

            $table->boolean('is_published')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
