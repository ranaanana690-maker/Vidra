@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">هياكل الرسوم</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">هياكل الرسوم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">مبالغ الرسوم حسب القسم لكل سنة دراسية</p>
    </div>
    <x-core-package::btn :href="route('feeStructure.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إضافة هيكل
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('feeStructure.index') }}"
          style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.select name="academic_year_id" label="السنة الدراسية">
            <option value="">كل السنوات</option>
            @foreach($academicYears as $year)
            <option value="{{ $year->academic_year_id }}" @selected(request('academic_year_id') == $year->academic_year_id)>{{ $year->year_range }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="class_id" label="القسم">
            <option value="">كل الأقسام</option>
            @foreach($classes as $class)
            <option value="{{ $class->class_id }}" @selected(request('class_id') == $class->class_id)>{{ $class->class_name }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="fee_category_id" label="الصنف">
            <option value="">كل الأصناف</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->fee_category_id }}" @selected(request('fee_category_id') == $cat->fee_category_id)>{{ $cat->category_name }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="frequency" label="الدورية">
            <option value="">الكل</option>
            <option value="once" @selected(request('frequency') === 'once')>مرة واحدة</option>
            <option value="monthly" @selected(request('frequency') === 'monthly')>شهري</option>
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('feeStructure.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الموجه إليه</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الصنف</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الدورية</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">السنة الدراسية</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المبلغ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ الاستحقاق</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">{{ $item->targetLabel() }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->feeCategory?->category_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->frequency === 'monthly' ? 'شهري'.($item->billing_month ? ' · '.$item->billing_month : '') : 'مرة واحدة' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->academicYear?->year_range ?? '—' }}</td>
                <td style="padding:.75rem 1rem;text-align:right;font-weight:600;color:#0f766e;">دج{{ number_format($item->amount, 2) }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->due_date?->format('d M Y') ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('feeStructure.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('feeStructure.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('feeStructure.destroy', $item) }}" onsubmit="return confirm('حذف هيكل الرسوم هذا؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                    <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد هياكل رسوم.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
