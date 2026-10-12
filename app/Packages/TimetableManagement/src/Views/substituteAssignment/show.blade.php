@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('substituteAssignment.index') }}" style="color:#64748b;text-decoration:none;">الاستخلاف</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">Substitution #{{ $substituteAssignment->substitute_id }}</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إسناد الاستخلاف</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">{{ $substituteAssignment->date_of_substitution?->format('d M Y') }}</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <x-core-package::btn :href="route('substituteAssignment.edit', $substituteAssignment)" color="secondary">تعديل</x-core-package::btn>
        <form method="POST" action="{{ route('substituteAssignment.destroy', $substituteAssignment) }}" onsubmit="return confirm('حذف هذا الاستخلاف؟')">
            @csrf @method('DELETE')
            <x-core-package::btn type="submit" color="danger">حذف</x-core-package::btn>
        </form>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
    <x-core-package::card title="خانة جدول الحصص">
        <dl style="display:grid;gap:.875rem;">
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">القسم / الفوج</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:.25rem 0 0;">
                    {{ $substituteAssignment->timetable?->schoolClass?->class_name }} – {{ $substituteAssignment->timetable?->section?->section_name }}
                </dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">المادة</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">{{ $substituteAssignment->timetable?->subject?->subject_name ?? '—' }}</dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">اليوم / الحصة</dt>
                <dd style="font-size:.9375rem;color:#475569;margin:.25rem 0 0;">
                    {{ $substituteAssignment->timetable?->day?->day_name }} |
                    {{ $substituteAssignment->timetable?->period?->start_time }} – {{ $substituteAssignment->timetable?->period?->end_time }}
                </dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">تاريخ الاستخلاف</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:.25rem 0 0;">{{ $substituteAssignment->date_of_substitution?->format('d M Y') }}</dd>
            </div>
        </dl>
    </x-core-package::card>

    <x-core-package::card title="تفاصيل الأستاذ">
        <dl style="display:grid;gap:.875rem;">
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">الأستاذ الأصلي</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#dc2626;margin:.25rem 0 0;">
                    {{ $substituteAssignment->originalTeacher?->first_name }} {{ $substituteAssignment->originalTeacher?->last_name }}
                </dd>
            </div>
            <div>
                <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;">الأستاذ المستخلف</dt>
                <dd style="font-size:.9375rem;font-weight:600;color:#16a34a;margin:.25rem 0 0;">
                    {{ $substituteAssignment->substituteTeacher?->first_name }} {{ $substituteAssignment->substituteTeacher?->last_name }}
                </dd>
            </div>
        </dl>
    </x-core-package::card>
</div>

@endsection
