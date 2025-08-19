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
       Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image')->nullable();
            $table->json('content')->nullable();
            $table->text('description')->nullable();
            $table->json('learning_outcomes')->nullable();
            $table->decimal('course_fee', 15, 2)->nullable();
            $table->text('target_audience')->nullable();
            $table->json('entry_requirement')->nullable();
            $table->json('curriculum')->nullable(); 
            $table->json('course_content')->nullable();
            $table->json('learning_experience')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
