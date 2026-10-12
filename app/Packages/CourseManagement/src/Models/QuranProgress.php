<?php

namespace App\Packages\CourseManagement\Models;

use Illuminate\Database\Eloquent\Model;

class QuranProgress extends Model
{
    protected $table = 'quran_progress';

    protected $primaryKey = 'progress_id';

    public $incrementing = true;

    protected $keyType = 'int';

    protected $fillable = [
        'enrollment_id',
        'surah',
        'from_ayah',
        'to_ayah',
        'activity',
        'evaluation',
        'recorded_at',
        'notes',
    ];

    protected $casts = [
        'recorded_at' => 'date',
    ];

    public const ACTIVITIES = ['Hifz', 'Muraja3a', 'Tajweed'];

    public function enrollment()
    {
        return $this->belongsTo(CourseEnrollment::class, 'enrollment_id');
    }
}
