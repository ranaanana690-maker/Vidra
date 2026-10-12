<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('course_id');
            $table->string('name', 100);
            $table->string('code', 20)->unique()->nullable();
            $table->enum('category', ['quran', 'language', 'soroban', 'other'])->default('other');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->unsignedInteger('duration_weeks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
