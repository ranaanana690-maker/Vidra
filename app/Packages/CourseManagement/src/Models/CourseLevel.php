<?php

namespace App\Packages\CourseManagement\Models;

use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    protected $table = 'course_levels';

    protected $primaryKey = 'level_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'course_id',
        'level_name',
        'level_order',
        'description',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'level_id');
    }
}
