@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">تسجيلات الدورات</span>
</nav>
@endsection

@section('content')

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تسجيلات الدورات</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">جميع تسجيلات التلاميذ في الدورات</p>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('courses.enrollments.index') }}"
          style="display:grid;grid-template-columns:1fr 200px auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.select name="course_id" label="الدورة">
            <option value="" @selected(!request('course_id'))>كل الدورات</option>
            @foreach($courses as $course)
            <option value="{{ $course->course_id }}" @selected((string)request('course_id') === (string)$course->course_id)>
                {{ $course->name }}
            </option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="status" label="الحالة">
            <option value="" @selected(!request('status'))>الكل</option>
            @foreach(['Active', 'Completed', 'Dropped'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ['Active'=>'نشط','Completed'=>'مكتمل','Dropped'=>'منسحب'][$s] ?? $s }}</option>
            @endforeach
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('courses.enrollments.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التلميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الدورة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الطور</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">
                    {{ $item->student->first_name ?? '' }} {{ $item->student->last_name ?? '' }}
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->course->name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->level->level_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge :color="$item->status === 'Active' ? 'green' : 'gray'">{{ ['Active'=>'نشط','Completed'=>'مكتمل','Dropped'=>'منسحب'][$item->status] ?? $item->status }}</x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::btn :href="route('courses.show', $item->course_id)" color="primary" size="sm">عرض</x-core-package::btn>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">
                    لا يوجد تسجيلات.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
