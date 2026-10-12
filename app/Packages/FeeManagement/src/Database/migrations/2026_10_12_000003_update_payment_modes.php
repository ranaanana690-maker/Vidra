<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /** DZ payment methods: Cash, CCP, BaridiMob, Bank Transfer. */
    public function up(): void
    {
        DB::statement("ALTER TABLE fee_payments MODIFY payment_mode ENUM('Cash','CCP','BaridiMob','Bank Transfer') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE fee_payments MODIFY payment_mode ENUM('Cash','Card','UPI','Bank Transfer') NOT NULL");
    }
};
