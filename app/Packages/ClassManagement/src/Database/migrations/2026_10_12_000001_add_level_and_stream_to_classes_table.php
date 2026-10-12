<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * DZ tutoring-center levels & secondary streams.
     * level:  primary | middle | secondary (nullable for legacy rows)
     * stream: tc-st | tc-l | se | math | tm | ge | philo | lang (secondary only)
     */
    public function up(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->string('level', 20)->nullable()->after('class_code');
            $table->string('stream', 30)->nullable()->after('level');
            $table->index('level');
            $table->index('stream');
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropIndex(['level']);
            $table->dropIndex(['stream']);
            $table->dropColumn(['level', 'stream']);
        });
    }
};
