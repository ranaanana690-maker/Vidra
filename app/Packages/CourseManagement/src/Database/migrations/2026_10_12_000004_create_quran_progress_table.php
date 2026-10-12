<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quran_progress', function (Blueprint $table) {
            $table->increments('progress_id');
            $table->unsignedInteger('enrollment_id');
            $table->string('surah', 100);
            $table->unsignedInteger('from_ayah')->nullable();
            $table->unsignedInteger('to_ayah')->nullable();
            $table->enum('activity', ['Hifz', 'Muraja3a', 'Tajweed'])->default('Hifz');
            $table->string('evaluation', 50)->nullable();
            $table->date('recorded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('enrollment_id')->references('enrollment_id')->on('course_enrollments')->onDelete('cascade');
            $table->index(['enrollment_id', 'recorded_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quran_progress');
    }
};
