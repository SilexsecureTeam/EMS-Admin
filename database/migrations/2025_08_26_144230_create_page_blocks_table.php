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
        Schema::create('page_blocks', function (Blueprint $table) {
            $table->id();
             $table->string('image')->nullable();
            $table->string('header')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('title1')->nullable();
            $table->text('content1')->nullable();
            $table->string('title2')->nullable();
            $table->text('content2')->nullable();
            $table->string('title3')->nullable();
            $table->text('content3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_blocks');
    }
};
