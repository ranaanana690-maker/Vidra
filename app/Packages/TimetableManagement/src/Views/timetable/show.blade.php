@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('timetable.index') }}" style="color:#64748b;text-decoration:none;">جدول الحصص</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">Entry #{{ $timetable->timetable_id }}</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">مدخل جدول الحصص</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">
            {{ $timetable->schoolClass?->class_name }} – {{ $timetable->section?->section_name }} | {{ $timetable->day?->day_name }}
        </p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <x-core-package::btn :href="route('timetable.edit', $timetable)" color="secondary">تعديل</x-core-package::btn>
        <form method="POST" action="{{ route('timetable.destroy', $timetable) }}" onsubmit="return confirm('حذف هذا المدخل؟')">
            @csrf @method('DELETE')
            <x-core-package::btn type="submit" color="danger">حذف</x-core-package::btn>
        </form>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
    <x-core-package::card title="تفاصيل البرمجة">
        <dl style="display:grid;gap:.875rem;">
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">القسم</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:.25rem 0 0;">{{ $timetable->schoolClass?->class_name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">الفوج</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">{{ $timetable->section?->section_name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">السنة الدراسية</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">{{ $timetable->academicYear?->year_range ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">يوم</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">{{ $timetable->day?->day_name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">حصة</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">
                    {{ $timetable->period?->start_time }} – {{ $timetable->period?->end_time }}
                </dd>
            </div>
        </dl>
    </x-core-package::card>

    <x-core-package::card title="تفاصيل الإسناد">
        <dl style="display:grid;gap:.875rem;">
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">المادة</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:.25rem 0 0;">{{ $timetable->subject?->subject_name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">أستاذ</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">
                    {{ $timetable->teacher?->first_name }} {{ $timetable->teacher?->last_name }}
                </dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">قاعة</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">
                    {{ $timetable->room?->room_name }}
                    @if($timetable->room)
                    <x-core-package::badge color="blue">{{ $timetable->room->room_type }}</x-core-package::badge>
                    @endif
                </dd>
            </div>
        </dl>
    </x-core-package::card>
</div>

@endsection
