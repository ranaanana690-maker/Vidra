<?php

namespace App\Packages\CourseManagement\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $primaryKey = 'course_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'price',
        'duration_weeks',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'quran' => 'Quran',
        'language' => 'Language',
        'soroban' => 'Soroban',
        'other' => 'Other',
    ];

    public function levels()
    {
        return $this->hasMany(CourseLevel::class, 'course_id')->orderBy('level_order');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id');
    }
}
