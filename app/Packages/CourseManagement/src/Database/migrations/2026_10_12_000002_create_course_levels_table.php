<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_levels', function (Blueprint $table) {
            $table->increments('level_id');
            $table->unsignedInteger('course_id');
            $table->string('level_name', 100);
            $table->unsignedInteger('level_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');
            $table->unique(['course_id', 'level_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_levels');
    }
};
