@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('exam.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">الامتحانات</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل الامتحان</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل الامتحان</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تحديث تفاصيل الامتحان</p>
    </div>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('exam.update', $exam) }}">
        @csrf
        @method('PUT')

        <x-core-package::form.input name="exam_name" label="اسم الامتحان" value="{{ old('exam_name', $exam->exam_name) }}" required />
        
        <x-core-package::form.select name="academic_year_id" label="السنة الدراسية" required>
            <option value="">اختر السنة الدراسية</option>
            @foreach($academicYears ?? [] as $year)
            <option value="{{ $year->academic_year_id }}" @selected(old('academic_year_id', $exam->academic_year_id) == $year->academic_year_id)>{{ $year->title }}</option>
            @endforeach
        </x-core-package::form.select>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <x-core-package::form.input name="start_date" label="تاريخ البداية" type="date" value="{{ old('start_date', $exam->start_date?->format('Y-m-d')) }}" required />
            <x-core-package::form.input name="end_date" label="تاريخ النهاية" type="date" value="{{ old('end_date', $exam->end_date?->format('Y-m-d')) }}" required />
        </div>

        <x-core-package::form.textarea name="description" label="الوصف" rows="3">{{ old('description', $exam->description) }}</x-core-package::form.textarea>

        <x-core-package::form.select name="is_final" label="نوع الامتحان">
            <option value="0" @selected(!$exam->is_final)>امتحان عادي</option>
            <option value="1" @selected($exam->is_final)>امتحان نهائي</option>
        </x-core-package::form.select>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <x-core-package::btn type="submit" color="primary">تحديث الامتحان</x-core-package::btn>
            <x-core-package::btn :href="route('exam.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

@endsection