@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('substituteAssignment.index') }}" style="color:#64748b;text-decoration:none;">الاستخلاف</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">إضافة استخلاف</span>
</nav>
@endsection

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة إسناد استخلاف</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تسجيل استخلاف أستاذ لتاريخ محدد</p>
    </div>

    <x-core-package::card>
        <form method="POST" action="{{ route('substituteAssignment.store') }}">
            @csrf
            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <x-core-package::form.select name="timetable_id" label="خانة جدول الحصص" required>
                    <option value="">اختر الخانة</option>
                    @foreach($timetables as $tt)
                    <option value="{{ $tt->timetable_id }}" @selected(old('timetable_id') == $tt->timetable_id)>
                        {{ $tt->schoolClass?->class_name }} – {{ $tt->section?->section_name }} |
                        {{ $tt->day?->day_name }} |
                        {{ $tt->subject?->subject_name }} |
                        {{ $tt->period?->start_time }} – {{ $tt->period?->end_time }}
                    </option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="original_teacher_id" label="الأستاذ الأصلي" required>
                    <option value="">اختر الأستاذ</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->staff_id }}" @selected(old('original_teacher_id') == $teacher->staff_id)>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="substitute_teacher_id" label="الأستاذ المستخلف" required>
                    <option value="">اختر المستخلف</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->staff_id }}" @selected(old('substitute_teacher_id') == $teacher->staff_id)>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.input name="date_of_substitution" label="تاريخ الاستخلاف" type="date" required
                    value="{{ old('date_of_substitution') }}" />

                @if($errors->any())
                <x-core-package::alert type="error">
                    <ul style="margin:0;padding-left:1rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-core-package::alert>
                @endif

                <div style="display:flex;gap:.75rem;">
                    <x-core-package::btn type="submit" color="primary">حفظ الاستخلاف</x-core-package::btn>
                    <x-core-package::btn :href="route('substituteAssignment.index')" color="secondary">إلغاء</x-core-package::btn>
                </div>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
