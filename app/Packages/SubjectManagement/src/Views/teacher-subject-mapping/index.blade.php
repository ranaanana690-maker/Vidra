@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">إسنادات الأساتذة للمواد</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إسنادات الأساتذة للمواد</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">من يُدرِّس أي مادة في أي قسم</p>
    </div>
    <x-core-package::btn :href="route('teacher-subject-mappings.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إسناد أستاذ
    </x-core-package::btn>
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1.25rem;">{{ session('success') }}</x-core-package::alert>
@endif

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('teacher-subject-mappings.index') }}"
          style="display:grid;grid-template-columns:1fr 1fr 1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.select name="teacher_id" label="الأستاذ">
            <option value="">كل الأساتذة</option>
            @foreach($teachers as $teacher)
            <option value="{{ $teacher->staff_id }}" @selected((string)request('teacher_id') === (string)$teacher->staff_id)>
                {{ $teacher->first_name }} {{ $teacher->last_name }}
            </option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="subject_id" label="المادة">
            <option value="">كل المواد</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject->subject_id }}" @selected((string)request('subject_id') === (string)$subject->subject_id)>{{ $subject->subject_name }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="class_id" label="القسم">
            <option value="">كل الأقسام</option>
            @foreach($classes as $class)
            <option value="{{ $class->class_id }}" @selected((string)request('class_id') === (string)$class->class_id)>{{ $class->class_name }}</option>
            @endforeach
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('teacher-subject-mappings.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الأستاذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المادة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">القسم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الفوج</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">
                    {{ $item->teacher ? $item->teacher->first_name.' '.$item->teacher->last_name : '—' }}
                </td>
                <td style="padding:.75rem 1rem;color:#475569;">{{ $item->subject->subject_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->schoolClass->class_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->section->section_name ?? 'All' }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('teacher-subject-mappings.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('teacher-subject-mappings.destroy', $item) }}"
                              onsubmit="return confirm('إزالة هذا الإسناد؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">إزالة</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا توجد إسنادات.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
