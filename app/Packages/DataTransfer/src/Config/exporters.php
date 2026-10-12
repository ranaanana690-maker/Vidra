<?php

return [
    'student' => [
        'title'    => 'التلاميذ',
        'exporter' => \App\Packages\DataTransfer\Helpers\Exporters\Student\Exporter::class,
    ],
    'staff' => [
        'title'    => 'الطاقم',
        'exporter' => \App\Packages\DataTransfer\Helpers\Exporters\Staff\Exporter::class,
    ],
    'salary' => [
        'title'    => 'تفاصيل الرواتب',
        'exporter' => \App\Packages\DataTransfer\Helpers\Exporters\Salary\Exporter::class,
    ],
    'student_fee' => [
        'title'    => 'رسوم التلاميذ',
        'exporter' => \App\Packages\DataTransfer\Helpers\Exporters\StudentFee\Exporter::class,
    ],
];
