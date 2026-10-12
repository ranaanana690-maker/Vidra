<?php

namespace App\Packages\CourseManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Packages\CourseManagement\Models\CourseEnrollment;
use App\Packages\CourseManagement\Models\QuranProgress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuranProgressController extends Controller
{
    public function store(Request $request, CourseEnrollment $enrollment): RedirectResponse
    {
        abort_unless($enrollment->course->category === 'quran', 403, 'Progress tracking is for Quran courses only.');

        $validated = $request->validate([
            'surah' => 'required|string|max:100',
            'from_ayah' => 'nullable|integer|min:1',
            'to_ayah' => 'nullable|integer|min:1',
            'activity' => 'required|string|in:Hifz,Muraja3a,Tajweed',
            'evaluation' => 'nullable|string|max:50',
            'recorded_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['recorded_at'] ??= now()->toDateString();

        $enrollment->quranProgress()->create($validated);

        return back()->with('success', 'Progress recorded successfully.');
    }

    public function update(Request $request, CourseEnrollment $enrollment, QuranProgress $progress): RedirectResponse
    {
        abort_unless($progress->enrollment_id === $enrollment->enrollment_id, 403);

        $validated = $request->validate([
            'surah' => 'required|string|max:100',
            'from_ayah' => 'nullable|integer|min:1',
            'to_ayah' => 'nullable|integer|min:1',
            'activity' => 'required|string|in:Hifz,Muraja3a,Tajweed',
            'evaluation' => 'nullable|string|max:50',
            'recorded_at' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $progress->update($validated);

        return back()->with('success', 'Progress updated successfully.');
    }

    public function destroy(CourseEnrollment $enrollment, QuranProgress $progress): RedirectResponse
    {
        abort_unless($progress->enrollment_id === $enrollment->enrollment_id, 403);

        $progress->delete();

        return back()->with('success', 'Progress entry deleted.');
    }
}
