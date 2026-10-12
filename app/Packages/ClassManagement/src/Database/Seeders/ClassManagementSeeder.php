<?php

namespace App\Packages\ClassManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassManagementSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->toDateTimeString();

        // Academic Years (DZ school year: September -> June)
        DB::table('academic_years')->insert([
            [
                'year_range' => '2026-2027',
                'start_date' => '2026-09-01',
                'end_date' => '2027-06-30',
                'is_current' => true,
                'description' => 'Current academic year',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'year_range' => '2025-2026',
                'start_date' => '2025-09-01',
                'end_date' => '2026-06-30',
                'is_current' => false,
                'description' => 'Previous academic year',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // DZ levels: 5 primary (AP) + 4 middle (AM) + secondary (1AS TC + 2AS/3AS streams)
        // [name, code, level, stream]
        $classes = [
            ['1AP', 'CLS-AP1', 'primary', null],
            ['2AP', 'CLS-AP2', 'primary', null],
            ['3AP', 'CLS-AP3', 'primary', null],
            ['4AP', 'CLS-AP4', 'primary', null],
            ['5AP', 'CLS-AP5', 'primary', null],
            ['1AM', 'CLS-AM1', 'middle', null],
            ['2AM', 'CLS-AM2', 'middle', null],
            ['3AM', 'CLS-AM3', 'middle', null],
            ['4AM', 'CLS-AM4', 'middle', null],
            ['1AS TC-ST', 'CLS-TCST', 'secondary', 'tc-st'],
            ['1AS TC-L', 'CLS-TCL', 'secondary', 'tc-l'],
            ['2AS-SE', 'CLS-2SE', 'secondary', 'se'],
            ['2AS-MATH', 'CLS-2MATH', 'secondary', 'math'],
            ['2AS-TM', 'CLS-2TM', 'secondary', 'tm'],
            ['2AS-GE', 'CLS-2GE', 'secondary', 'ge'],
            ['2AS-PHILO', 'CLS-2PHILO', 'secondary', 'philo'],
            ['2AS-LANG', 'CLS-2LANG', 'secondary', 'lang'],
            ['3AS-SE', 'CLS-3SE', 'secondary', 'se'],
            ['3AS-MATH', 'CLS-3MATH', 'secondary', 'math'],
            ['3AS-TM', 'CLS-3TM', 'secondary', 'tm'],
            ['3AS-GE', 'CLS-3GE', 'secondary', 'ge'],
            ['3AS-PHILO', 'CLS-3PHILO', 'secondary', 'philo'],
            ['3AS-LANG', 'CLS-3LANG', 'secondary', 'lang'],
        ];

        foreach ($classes as [$name, $code, $level, $stream]) {
            DB::table('classes')->insert([
                'class_name' => $name,
                'class_code' => $code,
                'level' => $level,
                'stream' => $stream,
                'academic_year_id' => 1,
                'description' => "DZ tutoring level {$name}",
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Sections (groups/أفواج): A+B for primary (classes 1-5 -> section ids 1-10),
        // A only for the rest (ids 11-28). class_teacher_id cycles over staff 1-10.
        $sectionId = 0;
        $sections = [];
        foreach (range(1, 23) as $classId) {
            $groups = $classId <= 5 ? ['A', 'B'] : ['A'];
            foreach ($groups as $group) {
                $sectionId++;
                $sections[] = [$classId, $group, 30, (($sectionId - 1) % 10) + 1];
            }
        }

        foreach ($sections as [$classId, $sectionName, $capacity, $teacherId]) {
            DB::table('sections')->insert([
                'class_id' => $classId,
                'section_name' => $sectionName,
                'capacity' => $capacity,
                'class_teacher_id' => $teacherId,
                'description' => "Group {$sectionName} of class {$classId}",
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Batches: one per section (batch ids follow section insertion order,
        // so batches 1-10 are the primary A/B groups used by student enrollments).
        foreach ($sections as $i => [$classId, $sectionName, $_capacity, $_teacher]) {
            $sectionDbId = $i + 1;
            $batchCode = 'BCH-'.str_pad((string) $sectionDbId, 2, '0', STR_PAD_LEFT);
            DB::table('batches')->insert([
                'class_id' => $classId,
                'section_id' => $sectionDbId,
                'academic_year_id' => 1,
                'batch_name' => "Batch 2026-27 Class {$classId} {$sectionName}",
                'batch_code' => $batchCode,
                'start_date' => '2026-09-01',
                'end_date' => '2027-06-30',
                'start_time' => '08:00:00',
                'end_time' => '14:00:00',
                'is_active' => true,
                'description' => "Batch 2026-27 Class {$classId} {$sectionName}",
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
