<?php

namespace App\Packages\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Packages\CourseManagement\Models\Course;
use App\Packages\CourseManagement\Models\CourseEnrollment;
use App\Packages\StudentManagement\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseEnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = CourseEnrollment::with(['course', 'student', 'level']);

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->latest('enrollment_id')->paginate(15)->withQueryString();
        $courses = Course::where('is_active', true)->orderBy('name')->get();

        return view('course-management::enrollments.index', compact('items', 'courses'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,student_id',
            'level_id' => 'nullable|integer|exists:course_levels,level_id',
            'status' => 'nullable|string|in:Active,Completed,Dropped',
            'enrolled_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if (! empty($validated['level_id'])) {
            $ownsLevel = $course->levels()->where('level_id', $validated['level_id'])->exists();
            abort_unless($ownsLevel, 422, 'Level does not belong to this course.');
        }

        if ($course->enrollments()->where('student_id', $validated['student_id'])->exists()) {
            return back()->with('error', 'Student is already enrolled in this course.');
        }

        $course->enrollments()->create($validated);

        return back()->with('success', 'Student enrolled successfully.');
    }

    public function update(Request $request, CourseEnrollment $enrollment): RedirectResponse
    {
        $validated = $request->validate([
            'level_id' => 'nullable|integer|exists:course_levels,level_id',
            'status' => 'required|string|in:Active,Completed,Dropped',
            'notes' => 'nullable|string',
        ]);

        if (! empty($validated['level_id'])) {
            $ownsLevel = $enrollment->course->levels()->where('level_id', $validated['level_id'])->exists();
            abort_unless($ownsLevel, 422, 'Level does not belong to this course.');
        }

        $enrollment->update($validated);

        return back()->with('success', 'Enrollment updated successfully.');
    }

    public function destroy(CourseEnrollment $enrollment): RedirectResponse
    {
        $enrollment->delete();

        return back()->with('success', 'Enrollment removed.');
    }

    public function studentOptions(): array
    {
        return Student::where('status', 'Active')
            ->orderBy('first_name')
            ->get(['student_id', 'first_name', 'last_name', 'admission_number'])
            ->toArray();
    }
}
