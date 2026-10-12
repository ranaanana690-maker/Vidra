<?php

namespace App\Packages\ClassManagement\Models;

use App\Packages\StudentManagement\Models\Student;
use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

    protected $primaryKey = 'class_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'class_name',
        'class_code',
        'level',
        'stream',
        'description',
        'academic_year_id',
        'is_active',
    ];

    /** DZ tutoring-center levels (DB values are stable codes; labels are Arabic). */
    public const LEVELS = [
        'primary' => 'ابتدائي',
        'middle' => 'متوسط',
        'secondary' => 'ثانوي',
    ];

    /** DZ secondary streams (only meaningful when level = secondary). */
    public const STREAMS = [
        'tc-st' => 'جذع مشترك علوم وتكنولوجيا',
        'tc-l' => 'جذع مشترك آداب',
        'se' => 'علوم تجريبية',
        'math' => 'رياضيات',
        'tm' => 'تقني رياضي',
        'ge' => 'تسيير واقتصاد',
        'philo' => 'آداب وفلسفة',
        'lang' => 'لغات أجنبية',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }

    public function batches()
    {
        return $this->hasMany(Batch::class, 'class_id');
    }

    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Batch::class,
            'class_id',
            'student_id',
            'class_id',
            'student_id'
        )->via('enrollments');
    }
}
