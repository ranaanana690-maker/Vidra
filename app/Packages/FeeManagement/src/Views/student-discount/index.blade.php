@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">تخفيضات التلاميذ</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تخفيضات التلاميذ</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">التخفيضات المسندة للتلاميذ</p>
    </div>
    <x-core-package::btn :href="route('studentDiscount.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إسناد تخفيض
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('studentDiscount.index') }}"
          style="display:grid;grid-template-columns:1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث عن تلميذ" placeholder="اسم التلميذ..." value="{{ request('search') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('studentDiscount.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التلميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التخفيض</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">هيكل رسوم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;font-weight:600;color:#1e293b;">{{ $item->student?->first_name }} {{ $item->student?->last_name }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">
                    {{ $item->discount?->discount_name }}
                    <span style="color:#94a3b8;font-size:.75rem;">
                        ({{ $item->discount?->discount_type === 'Percentage' ? $item->discount?->discount_amount.'%' : 'دج'.number_format($item->discount?->discount_amount ?? 0, 2) }})
                    </span>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->feeStructure?->feeCategory?->category_name ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <x-core-package::btn :href="route('studentDiscount.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('studentDiscount.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('studentDiscount.destroy', $item) }}" onsubmit="return confirm('إزالة هذا الإسناد للتخفيض؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">إزالة</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد تخفيضات التلاميذ.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
