<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Monthly billing period on student obligations (YYYY-MM). */
    public function up(): void
    {
        Schema::table('student_fees', function (Blueprint $table) {
            $table->string('billing_period', 7)->nullable()->after('due_date');
            $table->index('billing_period');
        });
    }

    public function down(): void
    {
        Schema::table('student_fees', function (Blueprint $table) {
            $table->dropIndex(['billing_period']);
            $table->dropColumn('billing_period');
        });
    }
};
