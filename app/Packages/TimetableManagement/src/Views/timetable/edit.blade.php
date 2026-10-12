@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('timetable.index') }}" style="color:#64748b;text-decoration:none;">جدول الحصص</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">تعديل المدخل</span>
</nav>
@endsection

@section('content')

<div style="max-width:720px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل مدخل جدول الحصص</h1>
    </div>

    <x-core-package::card>
        <form method="POST" action="{{ route('timetable.update', $timetable) }}">
            @csrf @method('PUT')
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">

                <x-core-package::form.select name="class_id" label="القسم" required>
                    <option value="">اختر القسم</option>
                    @foreach($classes as $class)
                    <option value="{{ $class->class_id }}" @selected(old('class_id', $timetable->class_id) == $class->class_id)>{{ $class->class_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="section_id" label="الفوج" required>
                    <option value="">اختر الفوج</option>
                    @foreach($sections as $section)
                    <option value="{{ $section->section_id }}" @selected(old('section_id', $timetable->section_id) == $section->section_id)>{{ $section->section_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="academic_year_id" label="السنة الدراسية" required>
                    <option value="">اختر السنة</option>
                    @foreach($academicYears as $year)
                    <option value="{{ $year->academic_year_id }}" @selected(old('academic_year_id', $timetable->academic_year_id) == $year->academic_year_id)>{{ $year->year_range }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="day_id" label="يوم" required>
                    <option value="">اختر اليوم</option>
                    @foreach($days as $day)
                    <option value="{{ $day->day_id }}" @selected(old('day_id', $timetable->day_id) == $day->day_id)>{{ $day->day_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="period_id" label="حصة" required>
                    <option value="">اختر الحصة</option>
                    @foreach($periods as $period)
                    <option value="{{ $period->period_id }}" @selected(old('period_id', $timetable->period_id) == $period->period_id)>
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $period->start_time)->format('h:i A') }}
                        –
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $period->end_time)->format('h:i A') }}
                    </option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="subject_id" label="المادة" required>
                    <option value="">اختر المادة</option>
                    @foreach($subjects as $subject)
                    <option value="{{ $subject->subject_id }}" @selected(old('subject_id', $timetable->subject_id) == $subject->subject_id)>{{ $subject->subject_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="teacher_id" label="أستاذ" required>
                    <option value="">اختر الأستاذ</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->staff_id }}" @selected(old('teacher_id', $timetable->teacher_id) == $teacher->staff_id)>{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.select name="room_id" label="قاعة" required>
                    <option value="">اختر القاعة</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->room_id }}" @selected(old('room_id', $timetable->room_id) == $room->room_id)>{{ $room->room_name }} ({{ $room->room_type }})</option>
                    @endforeach
                </x-core-package::form.select>
            </div>

            @if($errors->any())
            <div style="margin-top:1.25rem;">
                <x-core-package::alert type="error">
                    <ul style="margin:0;padding-left:1rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-core-package::alert>
            </div>
            @endif

            <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
                <x-core-package::btn type="submit" color="primary">تحديث المدخل</x-core-package::btn>
                <x-core-package::btn :href="route('timetable.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
