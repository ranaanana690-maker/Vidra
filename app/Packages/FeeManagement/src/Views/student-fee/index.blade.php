@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">رسوم التلاميذ</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">رسوم التلاميذ</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تتبع التزامات رسوم التلاميذ الفردية</p>
    </div>
    <x-core-package::btn :href="route('studentFee.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إسناد رسم
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('studentFee.index') }}"
          style="display:grid;grid-template-columns:1fr 160px 160px auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث عن تلميذ" placeholder="الاسم..." value="{{ request('search') }}" />
        <x-core-package::form.select name="payment_status" label="الحالة">
            <option value="">الكل</option>
            <option value="Pending" @selected(request('payment_status') === 'Pending')>قيد الانتظار</option>
            <option value="Partially Paid" @selected(request('payment_status') === 'Partially Paid')>مدفوع جزئياً</option>
            <option value="Paid" @selected(request('payment_status') === 'Paid')>مدفوع</option>
        </x-core-package::form.select>
        <x-core-package::form.input name="billing_period" label="الفترة (YYYY-MM)" placeholder="مثال: 2026-10" value="{{ request('billing_period') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('studentFee.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التلميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الرسم / القسم</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المبلغ المستحق</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المجموع الواجب</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ الاستحقاق</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الفترة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            @php
                $statusColor = match($item->payment_status) {
                    'Paid' => 'green',
                    'Partially Paid' => 'orange',
                    default => 'yellow',
                };
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;">
                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $item->student?->first_name }} {{ $item->student?->last_name }}</p>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">
                    {{ $item->feeStructure?->feeCategory?->category_name ?? '—' }}
                    <span style="color:#94a3b8;font-size:.75rem;">· {{ $item->feeStructure?->schoolClass?->class_name ?? '' }}</span>
                </td>
                <td style="padding:.75rem 1rem;text-align:right;color:#374151;">دج{{ number_format($item->amount_due, 2) }}</td>
                <td style="padding:.75rem 1rem;text-align:right;font-weight:600;color:#0f766e;">دج{{ number_format($item->total_payable, 2) }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->due_date?->format('d M Y') ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->billing_period ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ $statusColor }}">{{ $item->payment_status }}</x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;flex-wrap:wrap;">
                        <x-core-package::btn :href="route('studentFee.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('feePayment.create', ['student_fee_id' => $item->student_fee_id])" color="green" size="sm">دفع</x-core-package::btn>
                        <x-core-package::btn :href="route('studentFee.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('studentFee.destroy', $item) }}" onsubmit="return confirm('حذف سجل الرسوم هذا؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد سجلات رسوم التلاميذ.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
