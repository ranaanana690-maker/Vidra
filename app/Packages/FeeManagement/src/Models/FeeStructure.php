<?php

namespace App\Packages\FeeManagement\Models;

use App\Packages\ClassManagement\Models\AcademicYear;
use App\Packages\ClassManagement\Models\SchoolClass;
use App\Packages\CourseManagement\Models\Course;
use App\Packages\SubjectManagement\Models\Subject;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $table = 'fee_structures';
    protected $primaryKey = 'fee_structure_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'class_id',
        'subject_id',
        'course_id',
        'frequency',
        'billing_month',
        'fee_category_id',
        'amount',
        'due_date',
        'academic_year_id',
    ];

    public const FREQUENCIES = [
        'once' => 'One-time',
        'monthly' => 'Monthly subscription',
    ];

    protected $casts = [
        'amount'   => 'decimal:2',
        'due_date' => 'date',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id', 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id', 'subject_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    /** Human target label: course name or class name (used in selects). */
    public function targetLabel(): string
    {
        if ($this->course) {
            return 'Course: '.$this->course->name;
        }
        if ($this->schoolClass) {
            return 'Class: '.$this->schoolClass->class_name;
        }

        return '—';
    }

    public function feeCategory()
    {
        return $this->belongsTo(FeeCategory::class, 'fee_category_id', 'fee_category_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function studentFees()
    {
        return $this->hasMany(StudentFee::class, 'fee_structure_id', 'fee_structure_id');
    }

    public function studentDiscounts()
    {
        return $this->hasMany(StudentDiscount::class, 'fee_structure_id', 'fee_structure_id');
    }
}
