<?php

namespace App\Packages\SubjectManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectManagementSeeder extends Seeder
{
    public function run(): void
    {
        $now = now()->toDateTimeString();

        // DZ subjects: [arabic name, code, type, optional]
        $subjects = [
            ['الرياضيات',              'MATH-01',   'Theory',    false],
            ['اللغة العربية',          'AR-01',     'Theory',    false],
            ['اللغة الفرنسية',         'FR-01',     'Theory',    false],
            ['اللغة الإنجليزية',       'EN-01',     'Theory',    false],
            ['التربية الإسلامية',      'ISLAM-01',  'Theory',    false],
            ['التربية المدنية',        'CIV-01',    'Theory',    false],
            ['التاريخ والجغرافيا',     'HISTGEO-01', 'Theory',    false],
            ['العلوم والتكنولوجيا',    'SCITECH-01', 'Theory',    false],
            ['العلوم الفيزيائية',      'PHYS-01',   'Theory',    false],
            ['العلوم الطبيعية',        'SVT-01',    'Theory',    false],
            ['الفلسفة',                'PHILO-01',  'Theory',    false],
            ['التسيير المحاسبي والمالي', 'GEST-01',  'Theory',    false],
            ['الإعلام الآلي',          'INFO-01',   'Practical', false],
            ['لغة أجنبية ثالثة',       'LANG3-01',  'Theory',    true],
            ['اللغة الأمازيغية',       'TAM-01',    'Theory',    true],
            ['التربية الفنية',         'ARTS-01',   'Practical', true],
        ];

        foreach ($subjects as [$name, $code, $type, $optional]) {
            DB::table('subjects')->insert([
                'subject_name' => $name,
                'subject_code' => $code,
                'subject_type' => $type,
                'description' => "مادة الدعم {$code}",
                'is_optional' => $optional,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Class Subjects per DZ level/stream (subject ids as seeded above).
        // Classes 1-5: primary | 6-9: middle | 10: TC-ST | 11: TC-L |
        // 12-17: 2AS streams | 18-23: 3AS streams.
        $map = [
            1 => [[1, 2, 3, 4, 5, 6, 7, 8], [13]],
            2 => [[1, 2, 3, 4, 5, 6, 7, 8], [13]],
            3 => [[1, 2, 3, 4, 5, 6, 7, 8], [13]],
            4 => [[1, 2, 3, 4, 5, 6, 7, 8], [13]],
            5 => [[1, 2, 3, 4, 5, 6, 7, 8], [13]],
            6 => [[1, 2, 3, 4, 5, 6, 7, 9, 10, 13], [14, 15]],
            7 => [[1, 2, 3, 4, 5, 6, 7, 9, 10, 13], [14, 15]],
            8 => [[1, 2, 3, 4, 5, 6, 7, 9, 10, 13], [14, 15]],
            9 => [[1, 2, 3, 4, 5, 6, 7, 9, 10, 13], [14, 15]],
            10 => [[1, 2, 3, 4, 5, 7, 9, 10, 13], [14]],
            11 => [[2, 3, 4, 5, 7, 1, 13], [14, 15]],
            12 => [[1, 9, 10, 2, 3, 4, 5, 7, 11], []],
            13 => [[1, 9, 2, 3, 4, 5, 7], [13]],
            14 => [[1, 9, 10, 2, 3, 4, 5, 7, 13], []],
            15 => [[12, 1, 2, 3, 4, 7, 5], [13]],
            16 => [[11, 2, 3, 4, 5, 7, 1], [14]],
            17 => [[2, 3, 4, 14, 5, 7], [15]],
            18 => [[1, 9, 10, 2, 3, 4, 5, 7, 11], []],
            19 => [[1, 9, 2, 3, 4, 5, 7], [13]],
            20 => [[1, 9, 10, 2, 3, 4, 5, 7, 13], []],
            21 => [[12, 1, 2, 3, 4, 7, 5], [13]],
            22 => [[11, 2, 3, 4, 5, 7, 1], [14]],
            23 => [[2, 3, 4, 14, 5, 7], [15]],
        ];

        foreach ($map as $classId => [$mandatory, $optional]) {
            foreach ($mandatory as $subjectId) {
                DB::table('class_subjects')->insert([
                    'class_id' => $classId,
                    'subject_id' => $subjectId,
                    'is_mandatory' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
            foreach ($optional as $subjectId) {
                DB::table('class_subjects')->insert([
                    'class_id' => $classId,
                    'subject_id' => $subjectId,
                    'is_mandatory' => false,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Teacher Subject Mappings (staff 1-8, classes/sections/subjects exist)
        $mappings = [
            [1, 1, 1, 1],
            [2, 2, 9, 3],
            [3, 3, 4, 5],
            [4, 6, 9, 11],
            [5, 6, 10, 11],
            [6, 7, 1, 13],
            [7, 9, 11, 17],
            [8, 10, 13, 19],
            [1, 12, 1, 21],
            [3, 16, 11, 25],
        ];

        foreach ($mappings as [$teacherId, $classId, $subjectId, $sectionId]) {
            DB::table('teacher_subject_mappings')->insertOrIgnore([
                'teacher_id' => $teacherId,
                'class_id' => $classId,
                'subject_id' => $subjectId,
                'section_id' => $sectionId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Curriculums (one per subject-academic year)
        foreach (range(1, 16) as $subjectId) {
            DB::table('curriculums')->insertOrIgnore([
                'subject_id' => $subjectId,
                'academic_year_id' => 1,
                'description' => "خطة المنهاج 2026-27 للمادة {$subjectId}",
                'syllabus_document_path' => 'dummy/dummy-image.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // Lesson Plans (2 per curriculum)
        foreach (range(1, 16) as $curriculumId) {
            DB::table('lesson_plans')->insert([
                [
                    'curriculum_id' => $curriculumId,
                    'topic_name' => 'الوحدة 1 — مدخل',
                    'objectives' => 'تعرف المفاهيم الأساسية',
                    'start_date' => '2026-09-05',
                    'end_date' => '2026-09-30',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'curriculum_id' => $curriculumId,
                    'topic_name' => 'الوحدة 2 — المفاهيم الأساسية',
                    'objectives' => 'توظيف المفاهيم المكتسبة',
                    'start_date' => '2026-10-01',
                    'end_date' => '2026-10-31',
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }

        // Textbooks (one per subject)
        foreach (range(1, 16) as $subjectId) {
            DB::table('textbooks')->insert([
                'subject_id' => $subjectId,
                'title' => "DZ textbook for subject {$subjectId}",
                'author' => '—',
                'publisher' => 'ONPS',
                'edition' => '2026',
                'isbn' => '978-9931-00-00'.str_pad((string) $subjectId, 2, '0', STR_PAD_LEFT).'-0',
                'textbook_file_path' => 'dummy/dummy-image.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
