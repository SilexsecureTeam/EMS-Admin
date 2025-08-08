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
            $table->text('content')->nullable(); // Main program body text
            $table->text('description')->nullable();
            $table->json('learning_outcomes')->nullable();
            $table->string('course_fee')->nullable(); // Changed from cost_plan
            $table->text('target_audience')->nullable();
            $table->text('entry_requirement')->nullable(); // Plain text now
            $table->json('curriculum')->nullable(); // Array of {title, content}
            $table->text('course_content')->nullable(); // For card section
            $table->string('learning_experience')->nullable();
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
