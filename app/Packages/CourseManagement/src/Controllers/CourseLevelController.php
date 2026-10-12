<?php

namespace App\Packages\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Packages\CourseManagement\Models\Course;
use App\Packages\CourseManagement\Models\CourseLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseLevelController extends Controller
{
    public function store(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'level_name' => 'required|string|max:100',
            'level_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $course->levels()->create($validated);

        return back()->with('success', 'Level added successfully.');
    }

    public function update(Request $request, Course $course, CourseLevel $level): RedirectResponse
    {
        abort_unless($level->course_id === $course->course_id, 403);

        $validated = $request->validate([
            'level_name' => 'required|string|max:100',
            'level_order' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $level->update($validated);

        return back()->with('success', 'Level updated successfully.');
    }

    public function destroy(Course $course, CourseLevel $level): RedirectResponse
    {
        abort_unless($level->course_id === $course->course_id, 403);

        $level->delete();

        return back()->with('success', 'Level deleted.');
    }
}
