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

    /** DZ tutoring-center levels (DB values are stable codes; labels are English until the Arabic phase). */
    public const LEVELS = [
        'primary' => 'Primary',
        'middle' => 'Middle',
        'secondary' => 'Secondary',
    ];

    /** DZ secondary streams (only meaningful when level = secondary). */
    public const STREAMS = [
        'tc-st' => 'TC Science & Technology',
        'tc-l' => 'TC Letters',
        'se' => 'Experimental Sciences',
        'math' => 'Mathematics',
        'tm' => 'Technical Mathematics',
        'ge' => 'Management & Economics',
        'philo' => 'Literature & Philosophy',
        'lang' => 'Foreign Languages',
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
