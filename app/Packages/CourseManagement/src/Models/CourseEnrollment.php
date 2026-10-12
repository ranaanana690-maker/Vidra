<?php

namespace App\Packages\CourseManagement\Models;

use App\Packages\StudentManagement\Models\Student;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    protected $table = 'course_enrollments';

    protected $primaryKey = 'enrollment_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'course_id',
        'student_id',
        'level_id',
        'status',
        'enrolled_at',
        'notes',
    ];

    protected $casts = [
        'enrolled_at' => 'date',
    ];

    public const STATUSES = ['Active', 'Completed', 'Dropped'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function level()
    {
        return $this->belongsTo(CourseLevel::class, 'level_id');
    }

    public function quranProgress()
    {
        return $this->hasMany(QuranProgress::class, 'enrollment_id')->orderByDesc('recorded_at');
    }
}
