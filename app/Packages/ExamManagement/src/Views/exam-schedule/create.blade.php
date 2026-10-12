@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('examSchedule.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">رزنامة الامتحانات</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة رزنامة</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة رزنامة امتحان</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إنشاء رزنامة امتحان جديدة</p>
    </div>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('examSchedule.store') }}">
        @csrf

        <x-core-package::form.select name="exam_id" label="امتحان" required>
            <option value="">اختر الامتحان</option>
            @foreach($exams ?? [] as $exam)
            <option value="{{ $exam->exam_id }}">{{ $exam->exam_name }}</option>
            @endforeach
        </x-core-package::form.select>

        <x-core-package::form.select name="class_id" label="القسم" required>
            <option value="">اختر القسم</option>
            @foreach($classes ?? [] as $class)
            <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
            @endforeach
        </x-core-package::form.select>

        <x-core-package::form.select name="subject_id" label="المادة" required>
            <option value="">اختر المادة</option>
            @foreach($subjects ?? [] as $subject)
            <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
            @endforeach
        </x-core-package::form.select>

        <x-core-package::form.input name="exam_date" label="تاريخ الامتحان" type="date" required />

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <x-core-package::form.input name="start_time" label="وقت البداية" type="time" required />
            <x-core-package::form.input name="end_time" label="وقت النهاية" type="time" required />
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <x-core-package::form.input name="total_marks" label="المجموع الكلي" type="number" required />
            <x-core-package::form.input name="passing_marks" label="علامة النجاح" type="number" required />
        </div>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <x-core-package::btn type="submit" color="primary">إنشاء رزنامة</x-core-package::btn>
            <x-core-package::btn :href="route('examSchedule.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

@endsection