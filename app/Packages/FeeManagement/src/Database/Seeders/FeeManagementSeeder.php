<?php

namespace App\Packages\FeeManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeeManagementSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->toDateTimeString();

        // Fee Categories
        DB::table('fee_categories')->insert([
            ['category_name' => 'Tuition Fee',       'description' => 'رسوم الدراسة الشهرية',         'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Examination Fee',   'description' => 'رسم إجراء الامتحانات', 'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Library Fee',       'description' => 'رسم سنوي للوصول إلى المكتبة',       'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Sports Fee',        'description' => 'رسم الرياضة والأنشطة البدنية',    'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Computer Lab Fee',  'description' => 'رسوم استخدام مخبر الإعلام الآلي',      'created_at' => $now, 'updated_at' => $now],
            ['category_name' => 'Transport Fee',     'description' => 'رسوم النقل المدرسي',    'created_at' => $now, 'updated_at' => $now],
        ]);

        // Fee Structures — per class (1-5), per category
        // class_id=1 (Class 1), fee structures for categories 1-4
        $feeStructures = [
            [1, 1, 3500.00, '2024-05-10', 1],
            [1, 2,  500.00, '2024-09-15', 1],
            [1, 3,  300.00, '2024-05-10', 1],
            [1, 4,  400.00, '2024-05-10', 1],
            [2, 1, 3800.00, '2024-05-10', 1],
            [2, 2,  500.00, '2024-09-15', 1],
            [3, 1, 4000.00, '2024-05-10', 1],
            [3, 2,  600.00, '2024-09-15', 1],
            [4, 1, 4200.00, '2024-05-10', 1],
            [5, 1, 4500.00, '2024-05-10', 1],
        ];

        foreach ($feeStructures as [$classId, $categoryId, $amount, $dueDate, $ayId]) {
            DB::table('fee_structures')->insert([
                'class_id'         => $classId,
                'fee_category_id'  => $categoryId,
                'amount'           => $amount,
                'due_date'         => $dueDate,
                'academic_year_id' => $ayId,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
        }

        // Student Fees — students 1-4 for fee structures 1-4 (Class 1)
        $studentFees = [
            [1, 1, 3500.00, 0, 0, 3500.00, 'Paid',           '2024-05-10'],
            [1, 2,  500.00, 0, 0,  500.00, 'Paid',           '2024-09-15'],
            [1, 3,  300.00, 0, 0,  300.00, 'Paid',           '2024-05-10'],
            [1, 4,  400.00, 0, 0,  400.00, 'Paid',           '2024-05-10'],
            [2, 1, 3500.00, 0, 0, 3500.00, 'Paid',           '2024-05-10'],
            [2, 2,  500.00, 0, 0,  500.00, 'Pending',        '2024-09-15'],
            [3, 1, 3500.00, 200, 0, 3300.00, 'Partially Paid','2024-05-10'],
            [3, 3,  300.00, 0, 0,  300.00, 'Pending',        '2024-05-10'],
            [4, 1, 3500.00, 0, 0, 3500.00, 'Paid',           '2024-05-10'],
            [4, 2,  500.00, 0, 50,  550.00, 'Pending',       '2024-09-15'],
        ];

        foreach ($studentFees as [$studentId, $feeStructureId, $due, $discount, $penalty, $total, $status, $dueDate]) {
            DB::table('student_fees')->insert([
                'student_id'      => $studentId,
                'fee_structure_id'=> $feeStructureId,
                'amount_due'      => $due,
                'discount_amount' => $discount,
                'penalty_amount'  => $penalty,
                'total_payable'   => $total,
                'payment_status'  => $status,
                'due_date'        => $dueDate,
                'created_at'      => $now,
                'updated_at'      => $now,
            ]);
        }

        // Fee Payments (for Paid student fees: student_fee_ids 1,2,3,4,5,9)
        $payments = [
            [1, '2024-04-30', 3500.00, 'CCP',           'TXN-2024-0001'],
            [2, '2024-09-01', 500.00,  'BaridiMob',     'TXN-2024-0002'],
            [3, '2024-04-30', 300.00,  'Cash',          null],
            [4, '2024-04-30', 400.00,  'Cash',          null],
            [5, '2024-04-30', 3500.00, 'Bank Transfer', 'TXN-2024-0005'],
            [7, '2024-04-30', 3300.00, 'CCP',           'TXN-2024-0007'],
            [9, '2024-04-30', 3500.00, 'Cash',          null],
        ];

        foreach ($payments as [$studentFeeId, $paymentDate, $amount, $mode, $ref]) {
            DB::table('fee_payments')->insert([
                'student_fee_id'        => $studentFeeId,
                'payment_date'          => $paymentDate,
                'amount_paid'           => $amount,
                'payment_mode'          => $mode,
                'transaction_reference' => $ref,
                'created_at'            => $now,
                'updated_at'            => $now,
            ]);
        }

        // Centre model demo: monthly class subscription + one-time course fee.
        // Monthly subscription: class 1 (1AP), Tuition category, Oct 2026.
        DB::table('fee_structures')->insert([
            'class_id'         => 1,
            'subject_id'       => null,
            'course_id'        => null,
            'frequency'        => 'monthly',
            'billing_month'    => '2026-10',
            'fee_category_id'  => 1,
            'amount'           => 2000.00,
            'due_date'         => '2026-10-10',
            'academic_year_id' => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // One-time course fee: English course (course_id 2 from CourseManagementSeeder).
        DB::table('fee_structures')->insert([
            'class_id'         => null,
            'subject_id'       => null,
            'course_id'        => 2,
            'frequency'        => 'once',
            'billing_month'    => null,
            'fee_category_id'  => 1,
            'amount'           => 3000.00,
            'due_date'         => '2026-11-10',
            'academic_year_id' => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // Monthly obligations (student_fee ids 11-12) + course obligation (id 13).
        // Fee 12 is overdue + unpaid -> appears in the arrears report.
        $extraFees = [
            [1, 11, 2000.00, 'Paid',           '2026-10-10', '2026-10'],
            [2, 11, 2000.00, 'Pending',        '2026-10-10', '2026-10'],
            [1, 12, 3000.00, 'Partially Paid', '2026-11-10', null],
        ];

        foreach ($extraFees as [$studentId, $feeStructureId, $total, $status, $dueDate, $period]) {
            DB::table('student_fees')->insert([
                'student_id'       => $studentId,
                'fee_structure_id' => $feeStructureId,
                'amount_due'       => $total,
                'discount_amount'  => 0,
                'penalty_amount'   => 0,
                'total_payable'    => $total,
                'payment_status'   => $status,
                'due_date'         => $dueDate,
                'billing_period'   => $period,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
        }

        DB::table('fee_payments')->insert([
            [
                'student_fee_id'        => 11,
                'payment_date'          => '2026-10-05',
                'amount_paid'           => 2000.00,
                'payment_mode'          => 'Cash',
                'transaction_reference' => null,
                'created_at'            => $now,
                'updated_at'            => $now,
            ],
            [
                'student_fee_id'        => 13,
                'payment_date'          => '2026-10-08',
                'amount_paid'           => 1000.00,
                'payment_mode'          => 'BaridiMob',
                'transaction_reference' => 'BAR-2026-0001',
                'created_at'            => $now,
                'updated_at'            => $now,
            ],
        ]);
        // Discounts
        DB::table('discounts')->insert([
            [
                'discount_name'   => 'Sibling Discount',
                'discount_amount' => 10.00,
                'discount_type'   => 'Percentage',
                'description'     => 'تخفيض 10% للإخوة المتمدرسين في نفس المدرسة',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'discount_name'   => 'Merit Scholarship',
                'discount_amount' => 500.00,
                'discount_type'   => 'Fixed',
                'description'     => 'تخفيض ثابت 500 دج للمتفوقين',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'discount_name'   => 'Staff Ward Discount',
                'discount_amount' => 50.00,
                'discount_type'   => 'Percentage',
                'description'     => 'تخفيض 50% لأبناء طاقم التدريس',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ]);

        // Student Discounts
        DB::table('student_discounts')->insert([
            ['student_id' => 3, 'discount_id' => 1, 'fee_structure_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['student_id' => 3, 'discount_id' => 2, 'fee_structure_id' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Expenses
        $expenses = [
            ['2024-04-15', 25000.00, 'Maintenance',    'الصيانة السنوية للأقسام والأثاث'],
            ['2024-05-05', 12000.00, 'Utilities',      'فواتير الكهرباء والماء لشهر أفريل'],
            ['2024-05-20', 8500.00,  'Stationery',     'شراء الأدوات المدرسية للموظفين والتلاميذ'],
            ['2024-06-10', 45000.00, 'Infrastructure', 'تركيب جهاز عرض جديد في الأقسام'],
            ['2024-07-01', 6000.00,  'Events',         'مصاريف الاحتفال باليوم السنوي'],
            ['2024-08-15', 3500.00,  'Utilities',      'فواتير الكهرباء والماء لشهر جويلية'],
        ];

        foreach ($expenses as [$date, $amount, $category, $description]) {
            DB::table('expenses')->insert([
                'expense_date'     => $date,
                'amount'           => $amount,
                'expense_category' => $category,
                'description'      => $description,
                'created_at'       => $now,
                'updated_at'       => $now,
            ]);
        }

        // Financial Reports
        DB::table('financial_reports')->insert([
            [
                'report_type'         => 'Income',
                'report_period_start' => '2024-04-01',
                'report_period_end'   => '2024-06-30',
                'total_amount'        => 185000.00,
                'generated_at'        => $now,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
            [
                'report_type'         => 'Expense',
                'report_period_start' => '2024-04-01',
                'report_period_end'   => '2024-06-30',
                'total_amount'        => 100000.00,
                'generated_at'        => $now,
                'created_at'          => $now,
                'updated_at'          => $now,
            ],
        ]);
    }
}
