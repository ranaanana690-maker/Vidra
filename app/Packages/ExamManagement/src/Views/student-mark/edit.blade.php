@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('studentMark.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">نقاط التلاميذ</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل النقاط</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل نقاط التلاميذ</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تحديث تفاصيل النقاط</p>
    </div>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('studentMark.update', $studentMark) }}">
        @csrf @method('PUT')

        <x-core-package::form.input name="student_id" label="معرف التلميذ" type="number" value="{{ old('student_id', $studentMark->student_id) }}" required />
        
        <x-core-package::form.select name="schedule_id" label="رزنامة الامتحان" required>
            <option value="">اختر رزنامة الامتحان</option>
            @foreach($examSchedules ?? [] as $schedule)
            <option value="{{ $schedule->schedule_id }}" @selected(old('schedule_id', $studentMark->schedule_id) == $schedule->schedule_id)>
                {{ $schedule->exam?->exam_name ?? 'Exam #'.$schedule->exam_id }} - {{ $schedule->subject?->subject_name ?? 'Subject #'.$schedule->subject_id }}
            </option>
            @endforeach
        </x-core-package::form.select>

        <x-core-package::form.input name="marks_obtained" label="النقاط المحصل عليها" type="number" step="0.01" value="{{ old('marks_obtained', $studentMark->marks_obtained) }}" required />
        
        <x-core-package::form.input name="grade" label="المعدل/التقدير" value="{{ old('grade', $studentMark->grade) }}" />
        
        <x-core-package::form.textarea name="remarks" label="ملاحظات" rows="3">{{ old('remarks', $studentMark->remarks) }}</x-core-package::form.textarea>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <x-core-package::btn type="submit" color="primary">تحديث النقاط</x-core-package::btn>
            <x-core-package::btn :href="route('studentMark.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

@endsection