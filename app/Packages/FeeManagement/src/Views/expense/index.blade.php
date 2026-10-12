@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">المصاريف</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">المصاريف</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تتبع مصاريف تشغيل المدرسة</p>
    </div>
    <x-core-package::btn :href="route('expense.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إضافة مصروف
    </x-core-package::btn>
</div>

@if($totalAmount > 0)
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-bottom:1.25rem;">
    <x-core-package::stats-card label="المجموع المصفى" :value="'دج'.number_format($totalAmount, 2)" color="red" />
</div>
@endif

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('expense.index') }}"
          style="display:grid;grid-template-columns:1fr 1fr 1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث" placeholder="الصنف أو الوصف..." value="{{ request('search') }}" />
        <x-core-package::form.input name="from_date" label="من تاريخ" type="date" value="{{ request('from_date') }}" />
        <x-core-package::form.input name="to_date" label="إلى تاريخ" type="date" value="{{ request('to_date') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('expense.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التاريخ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الصنف</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الوصف</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المبلغ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;color:#64748b;">{{ $item->expense_date?->format('d M Y') }}</td>
                <td style="padding:.75rem 1rem;font-weight:600;color:#1e293b;">{{ $item->expense_category }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ Str::limit($item->description, 50) ?? '—' }}</td>
                <td style="padding:.75rem 1rem;text-align:right;font-weight:600;color:#dc2626;">دج{{ number_format($item->amount, 2) }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <x-core-package::btn :href="route('expense.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('expense.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('expense.destroy', $item) }}" onsubmit="return confirm('حذف هذا المصروف؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد مصاريف.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
