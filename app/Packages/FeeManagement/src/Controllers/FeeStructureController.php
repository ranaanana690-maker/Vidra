<?php

namespace App\Packages\FeeManagement\Controllers;

use App\Http\Controllers\Controller;
use App\Packages\ClassManagement\Models\AcademicYear;
use App\Packages\ClassManagement\Models\SchoolClass;
use App\Packages\CourseManagement\Models\Course;
use App\Packages\FeeManagement\Models\FeeCategory;
use App\Packages\FeeManagement\Models\FeeStructure;
use App\Packages\SubjectManagement\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeStructureController extends Controller
{
    public function index(Request $request): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $classes       = SchoolClass::orderBy('class_name')->get();
        $categories    = FeeCategory::orderBy('category_name')->get();

        $query = FeeStructure::with('schoolClass', 'feeCategory', 'academicYear', 'course', 'subject');

        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        if ($request->filled('fee_category_id')) {
            $query->where('fee_category_id', $request->fee_category_id);
        }
        if ($request->filled('frequency')) {
            $query->where('frequency', $request->frequency);
        }

        $items = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        return view('fee-management::fee-structure.index', compact('items', 'academicYears', 'classes', 'categories'));
    }

    public function create(): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $classes       = SchoolClass::orderBy('class_name')->get();
        $categories    = FeeCategory::orderBy('category_name')->get();
        $courses       = Course::where('is_active', true)->orderBy('name')->get();
        $subjects      = Subject::orderBy('subject_name')->get();
        $frequencies   = FeeStructure::FREQUENCIES;
        return view('fee-management::fee-structure.create', compact('academicYears', 'classes', 'categories', 'courses', 'subjects', 'frequencies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_id'         => 'nullable|integer|required_without:course_id',
            'course_id'        => 'nullable|integer|exists:courses,course_id|required_without:class_id',
            'subject_id'       => 'nullable|integer|exists:subjects,subject_id',
            'frequency'        => 'required|string|in:once,monthly',
            'billing_month'    => 'nullable|date_format:Y-m',
            'fee_category_id'  => 'required|integer',
            'amount'           => 'required|numeric|min:0',
            'due_date'         => 'required|date',
            'academic_year_id' => 'required|integer',
        ]);
        FeeStructure::create($validated);
        return redirect()->route('feeStructure.index')->with('success', 'تم إنشاء هيكل الرسوم بنجاح.');
    }

    public function show(FeeStructure $feeStructure): View
    {
        $feeStructure->load('schoolClass', 'feeCategory', 'academicYear', 'course', 'subject');
        return view('fee-management::fee-structure.show', compact('feeStructure'));
    }

    public function edit(FeeStructure $feeStructure): View
    {
        $academicYears = AcademicYear::orderBy('start_date', 'desc')->get();
        $classes       = SchoolClass::orderBy('class_name')->get();
        $categories    = FeeCategory::orderBy('category_name')->get();
        $courses       = Course::where('is_active', true)->orderBy('name')->get();
        $subjects      = Subject::orderBy('subject_name')->get();
        $frequencies   = FeeStructure::FREQUENCIES;
        return view('fee-management::fee-structure.edit', compact('feeStructure', 'academicYears', 'classes', 'categories', 'courses', 'subjects', 'frequencies'));
    }

    public function update(Request $request, FeeStructure $feeStructure): RedirectResponse
    {
        $validated = $request->validate([
            'class_id'         => 'nullable|integer|required_without:course_id',
            'course_id'        => 'nullable|integer|exists:courses,course_id|required_without:class_id',
            'subject_id'       => 'nullable|integer|exists:subjects,subject_id',
            'frequency'        => 'required|string|in:once,monthly',
            'billing_month'    => 'nullable|date_format:Y-m',
            'fee_category_id'  => 'required|integer',
            'amount'           => 'required|numeric|min:0',
            'due_date'         => 'required|date',
            'academic_year_id' => 'required|integer',
        ]);
        $feeStructure->update($validated);
        return redirect()->route('feeStructure.index')->with('success', 'تم تحديث هيكل الرسوم بنجاح.');
    }

    public function destroy(FeeStructure $feeStructure): RedirectResponse
    {
        $feeStructure->delete();
        return redirect()->route('feeStructure.index')->with('success', 'تم حذف هيكل الرسوم.');
    }
}
