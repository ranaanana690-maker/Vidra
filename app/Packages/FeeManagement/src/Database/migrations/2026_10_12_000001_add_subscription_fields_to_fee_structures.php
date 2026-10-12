<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Centre model: fee structures can target a class (monthly subscription),
     * a subject, or a course (one-time full payment) — at least one target.
     */
    public function up(): void
    {
        // class_id was NOT NULL without FK; allow course-only structures (no doctrine/dbal needed).
        DB::statement('ALTER TABLE fee_structures MODIFY class_id INT UNSIGNED NULL');

        Schema::table('fee_structures', function (Blueprint $table) {
            $table->unsignedInteger('subject_id')->nullable()->after('class_id');
            $table->unsignedInteger('course_id')->nullable()->after('subject_id');
            $table->enum('frequency', ['once', 'monthly'])->default('once')->after('amount');
            $table->string('billing_month', 7)->nullable()->after('frequency');
            $table->index('course_id');
            $table->index('frequency');
        });
    }

    public function down(): void
    {
        Schema::table('fee_structures', function (Blueprint $table) {
            $table->dropIndex(['course_id']);
            $table->dropIndex(['frequency']);
            $table->dropColumn(['subject_id', 'course_id', 'frequency', 'billing_month']);
        });

        DB::statement('ALTER TABLE fee_structures MODIFY class_id INT UNSIGNED NOT NULL');
    }
};
