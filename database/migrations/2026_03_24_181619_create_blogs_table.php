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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('category')->nullable(); // community, announcement, culture
            $table->string('author')->default('MKBA Editorial Team');
            $table->date('post_date')->nullable();
            $table->text('summary')->nullable(); // Short excerpt for the card
            $table->longText('description')->nullable(); // Full blog content
            $table->string('image')->nullable();
            
            // SEO Columns
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            $table->integer('status')->default(1); // 1: Published, 0: Draft
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
