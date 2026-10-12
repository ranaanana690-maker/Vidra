@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('examSchedule.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">رزنامة الامتحانات</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">عرض الرزنامة</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">رزنامة الامتحان</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تفاصيل الرزنامة</p>
    </div>
    <div style="display:flex;gap:.5rem;">
        <x-core-package::btn :href="route('examSchedule.edit', $examSchedule)" color="secondary">تعديل</x-core-package::btn>
        <form method="POST" action="{{ route('examSchedule.destroy', $examSchedule) }}" onsubmit="return confirm('حذف؟')">
            @csrf @method('DELETE')
            <x-core-package::btn type="submit" color="danger">حذف</x-core-package::btn>
        </form>
    </div>
</div>

<x-core-package::card>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">امتحان</p>
            <p style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">{{ $examSchedule->exam?->exam_name ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">القسم</p>
            <p style="font-size:.9375rem;color:#1e293b;margin:0;">{{ $examSchedule->schoolClass?->class_name ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">المادة</p>
            <p style="font-size:.9375rem;color:#1e293b;margin:0;">{{ $examSchedule->subject?->subject_name ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">التاريخ</p>
            <p style="font-size:.9375rem;color:#1e293b;margin:0;">{{ $examSchedule->exam_date?->format('d M Y') ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">الوقت</p>
            <p style="font-size:.9375rem;color:#1e293b;margin:0;">{{ $examSchedule->start_time?->format('H:i') ?? '—' }} - {{ $examSchedule->end_time?->format('H:i') ?? '—' }}</p>
        </div>
        <div>
            <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">النقاط</p>
            <p style="font-size:.9375rem;color:#1e293b;margin:0;">النجاح: {{ $examSchedule->passing_marks ?? '—' }} / المجموع: {{ $examSchedule->total_marks ?? '—' }}</p>
        </div>
    </div>
</x-core-package::card>

@endsection