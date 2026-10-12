@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">مدفوعات الرسوم</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">مدفوعات الرسوم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">كل معاملات الدفع</p>
    </div>
    <x-core-package::btn :href="route('feePayment.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        تسجيل دفعة
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('feePayment.index') }}"
          style="display:grid;grid-template-columns:160px 1fr 1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.select name="payment_mode" label="الطريقة">
            <option value="">كل الطرق</option>
            @foreach(['Cash','CCP','BaridiMob','Bank Transfer'] as $mode)
            <option value="{{ $mode }}" @selected(request('payment_mode') === $mode)>{{ $mode }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.input name="from_date" label="من تاريخ" type="date" value="{{ request('from_date') }}" />
        <x-core-package::form.input name="to_date" label="إلى تاريخ" type="date" value="{{ request('to_date') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('feePayment.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التلميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">صنف الرسوم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التاريخ</th>
                    <th style="padding:.625rem 1rem;text-align:right;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المبلغ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الطريقة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المرجع</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">
                    {{ $item->studentFee?->student?->first_name }} {{ $item->studentFee?->student?->last_name }}
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->studentFee?->feeStructure?->feeCategory?->category_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->payment_date?->format('d M Y') }}</td>
                <td style="padding:.75rem 1rem;text-align:right;font-weight:600;color:#0f766e;">دج{{ number_format($item->amount_paid, 2) }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ match($item->payment_mode) { 'Cash' => 'green', 'CCP' => 'blue', 'BaridiMob' => 'indigo', default => 'gray' } }}">{{ $item->payment_mode }}</x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;color:#94a3b8;font-size:.75rem;">{{ $item->transaction_reference ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <x-core-package::btn :href="route('feePayment.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('feePayment.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('feePayment.destroy', $item) }}" onsubmit="return confirm('حذف هذه الدفعة؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد مدفوعات.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
