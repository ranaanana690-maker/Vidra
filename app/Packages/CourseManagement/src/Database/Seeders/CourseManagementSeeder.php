<?php

namespace App\Packages\CourseManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseManagementSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->toDateTimeString();

        // Demo courses: [name, code, category, price, duration_weeks]
        $courses = [
            ['القرآن الكريم', 'QUR-01', 'quran', 0, 40],
            ['اللغة الإنجليزية', 'ENG-C01', 'language', 3000, 12],
            ['السوروبان', 'SOR-01', 'soroban', 2500, 16],
            ['اللغة الفرنسية', 'FR-C01', 'language', 3000, 12],
        ];

        foreach ($courses as [$name, $code, $category, $price, $weeks]) {
            DB::table('courses')->insert([
                'name' => $name,
                'code' => $code,
                'category' => $category,
                'description' => "Demo course {$code}",
                'price' => $price,
                'duration_weeks' => $weeks,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Levels for English (course 2) and Soroban (course 3)
        $levels = [
            [2, 'مبتدئ', 1],
            [2, 'متوسط', 2],
            [2, 'متقدم', 3],
            [3, 'المستوى 1 — الجمع والطرح', 1],
            [3, 'المستوى 2 — الضرب', 2],
            [3, 'المستوى 3 — القسمة الذهنية', 3],
        ];

        foreach ($levels as [$courseId, $levelName, $order]) {
            DB::table('course_levels')->insert([
                'course_id' => $courseId,
                'level_name' => $levelName,
                'level_order' => $order,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Demo enrollments (students 1-2 exist from StudentManagementSeeder)
        DB::table('course_enrollments')->insert([
            [
                'course_id' => 1,
                'student_id' => 1,
                'level_id' => null,
                'status' => 'Active',
                'enrolled_at' => '2026-09-05',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'course_id' => 1,
                'student_id' => 2,
                'level_id' => null,
                'status' => 'Active',
                'enrolled_at' => '2026-09-05',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'course_id' => 3,
                'student_id' => 1,
                'level_id' => 4,
                'status' => 'Active',
                'enrolled_at' => '2026-09-10',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Demo Quran progress for enrollment 1
        DB::table('quran_progress')->insert([
            'enrollment_id' => 1,
            'surah' => 'البقرة',
            'from_ayah' => 1,
            'to_ayah' => 20,
            'activity' => 'Hifz',
            'evaluation' => 'جيد جدا',
            'recorded_at' => '2026-10-01',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
