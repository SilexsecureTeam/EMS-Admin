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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('parent_page')->nullable();
            $table->json('sliders')->nullable();
            $table->string('header_title')->nullable();
            $table->text('header_description')->nullable();
            // for accommodate all pages
            $table->string('title_1')->nullable();
            $table->text('content_1')->nullable();
            $table->string('content_1_image')->nullable();
            $table->string('title_2')->nullable();
            $table->text('content_2')->nullable();
            $table->string('content_2_image')->nullable();
            $table->string('title_3')->nullable();
            $table->text('content_3')->nullable();
            $table->string('content_3_image')->nullable();
            $table->string('title_4')->nullable();
            $table->text('content_4')->nullable();
            $table->string('content_4_image')->nullable();
            // green area
            $table->string('green_title')->nullable();
            $table->text('green_description')->nullable();
            // footer
            $table->string('footer_title')->nullable();
            $table->string('footer_contact')->nullable();
            $table->text('footer_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
