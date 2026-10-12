<?php

return [
    'student' => [
        'title'    => 'التلاميذ',
        'importer' => \App\Packages\DataTransfer\Helpers\Importers\Student\Importer::class,
    ],
    'staff' => [
        'title'    => 'الطاقم',
        'importer' => \App\Packages\DataTransfer\Helpers\Importers\Staff\Importer::class,
    ],
    'salary' => [
        'title'    => 'تفاصيل الرواتب',
        'importer' => \App\Packages\DataTransfer\Helpers\Importers\Salary\Importer::class,
    ],
    'student_fee' => [
        'title'    => 'رسوم التلاميذ',
        'importer' => \App\Packages\DataTransfer\Helpers\Importers\StudentFee\Importer::class,
    ],
];
