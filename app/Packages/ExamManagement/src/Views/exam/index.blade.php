@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">الامتحانات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">الامتحانات</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إدارة سجلات الامتحانات</p>
    </div>
    <x-core-package::btn :href="route('exam.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>إنشاء امتحان</x-core-package::btn>
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1.25rem;">{{ session('success') }}</x-core-package::alert>
@endif

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('exam.index') }}"
          style="display:grid;grid-template-columns:1fr 160px auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث" placeholder="ابحث عن الامتحانات..." value="{{ request('search') }}" />
        <x-core-package::form.select name="academic_year_id" label="السنة الدراسية">
            <option value="">كل السنوات</option>
            @foreach($academicYears ?? [] as $year)
            <option value="{{ $year->academic_year_id }}" @selected(request('academic_year_id') == $year->academic_year_id)>{{ $year->title }}</option>
            @endforeach
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('exam.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">اسم الامتحان</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">السنة الدراسية</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الفترة الزمنية</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">النوع</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;">
                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $item->exam_name }}</p>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->academicYear?->title ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">
                    {{ $item->start_date?->format('d M') ?? '—' }} - {{ $item->end_date?->format('d M Y') ?? '—' }}
                </td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ $item->is_final ? 'blue' : 'gray' }}">
                        {{ $item->is_final ? 'نهائي' : 'عادي' }}
                    </x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('exam.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('exam.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('exam.destroy', $item) }}" onsubmit="return confirm('حذف هذا الامتحان؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا توجد امتحانات.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
