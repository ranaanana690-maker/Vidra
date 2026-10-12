<?php

namespace App\Packages\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Packages\CourseManagement\Models\Course;
use App\Packages\StudentManagement\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::withCount(['levels', 'enrollments']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                    ->orWhere('code', 'like', '%'.$request->search.'%');
            });
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $items = $query->orderBy('name')->paginate(15)->withQueryString();
        $categories = Course::CATEGORIES;

        return view('course-management::courses.index', compact('items', 'categories'));
    }

    public function create(): View
    {
        $categories = Course::CATEGORIES;

        return view('course-management::courses.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:courses,code',
            'category' => 'required|string|in:quran,language,soroban,other',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration_weeks' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $course = Course::create($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course): View
    {
        $course->load(['levels', 'enrollments.student', 'enrollments.level', 'enrollments.quranProgress']);

        $students = Student::where('status', 'Active')
            ->orderBy('first_name')
            ->get(['student_id', 'first_name', 'last_name', 'admission_number']);

        return view('course-management::courses.show', compact('course', 'students'));
    }

    public function edit(Course $course): View
    {
        $categories = Course::CATEGORIES;

        return view('course-management::courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'nullable|string|max:20|unique:courses,code,'.$course->course_id.',course_id',
            'category' => 'required|string|in:quran,language,soroban,other',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration_weeks' => 'nullable|integer|min:1',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $course->update($validated);

        return redirect()->route('courses.show', $course)
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted.');
    }
}
