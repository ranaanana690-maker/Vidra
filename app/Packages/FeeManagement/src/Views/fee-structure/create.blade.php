@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('feeStructure.index') }}" style="color:#64748b;text-decoration:none;">هياكل الرسوم</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة هيكل</span>
</nav>
@endsection

@section('content')

<div style="max-width:44rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة هيكل رسوم</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">حدد مبلغ الرسوم لقسم وصنف</p>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('feeStructure.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="academic_year_id" label="السنة الدراسية" required>
                    <option value="">اختر السنة...</option>
                    @foreach($academicYears as $year)
                    <option value="{{ $year->academic_year_id }}" @selected(old('academic_year_id') == $year->academic_year_id)>{{ $year->year_range }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="class_id" label="القسم (اتركه فارغا لرسوم الدورات)">
                    <option value="">اختر القسم...</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->class_id }}" @selected(old('class_id') == $class->class_id)>{{ $class->class_name }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="course_id" label="الدورة (اتركها فارغة لرسوم الأقسام)">
                    <option value="">اختر الدورة...</option>
                    @foreach($courses as $course)
                    <option value="{{ $course->course_id }}" @selected(old('course_id') == $course->course_id)>{{ $course->name }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="subject_id" label="المادة (اختياري)">
                    <option value="">اختر المادة...</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->subject_id }}" @selected(old('subject_id') == $subject->subject_id)>{{ $subject->subject_name }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="frequency" label="الدورية" required>
                    @foreach($frequencies as $code => $label)
                    <option value="{{ $code }}" @selected(old('frequency', 'once') === $code)>{{ $label }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input name="billing_month" label="شهر الفوترة (YYYY-MM، للشهري)" placeholder="مثال: 2026-10" value="{{ old('billing_month') }}" />
            </div>
            <x-core-package::form.select name="fee_category_id" label="صنف الرسوم" required>
                <option value="">اختر الصنف...</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->fee_category_id }}" @selected(old('fee_category_id') == $cat->fee_category_id)>{{ $cat->category_name }}</option>
                @endforeach
            </x-core-package::form.select>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="amount" label="المبلغ (دج)" type="number" required hint="مبلغ الرسوم بالدينار" value="{{ old('amount') }}" />
                <x-core-package::form.input name="due_date" label="تاريخ الاستحقاق" type="date" required value="{{ old('due_date') }}" />
            </div>
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">حفظ الهيكل</x-core-package::btn>
                <x-core-package::btn :href="route('feeStructure.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
