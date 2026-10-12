@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">المتأخرات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">متأخرات الرسوم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">التزامات غير مدفوعة تجاوزت تاريخ استحقاقها</p>
    </div>
    <x-core-package::badge color="red">المجموع المستحق: DA {{ number_format($totalDue, 2) }}</x-core-package::badge>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('studentFee.arrears') }}"
          style="display:grid;grid-template-columns:1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="billing_period" label="الفترة (YYYY-MM)" placeholder="مثال: 2026-10" value="{{ request('billing_period') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('studentFee.arrears')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التلميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الرسوم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الفترة</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المتبقي</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ الاستحقاق</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">
                    {{ $item->student?->first_name }} {{ $item->student?->last_name }}
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">
                    {{ $item->feeStructure?->feeCategory?->category_name ?? '—' }}
                    <span style="color:#94a3b8;font-size:.75rem;">· {{ $item->feeStructure?->targetLabel() }}</span>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->billing_period ?? '—' }}</td>
                <td style="padding:.75rem 1rem;text-align:right;font-weight:600;color:#b91c1c;">
                    DA {{ number_format($item->total_payable - $item->payments()->sum('amount_paid'), 2) }}
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->due_date?->format('d M Y') ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ $item->payment_status === 'Partially Paid' ? 'orange' : 'yellow' }}">{{ $item->payment_status }}</x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('studentFee.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('feePayment.create', ['student_fee_id' => $item->student_fee_id])" color="green" size="sm">دفع</x-core-package::btn>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد متأخرات. كل شيء سليم!</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
