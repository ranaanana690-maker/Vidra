@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('studentDiscount.index') }}" style="color:#64748b;text-decoration:none;">تخفيضات التلاميذ</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">التفاصيل</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تفاصيل تخفيض التلميذ</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">
            {{ $studentDiscount->student?->first_name }} {{ $studentDiscount->student?->last_name }} — {{ $studentDiscount->discount?->discount_name }}
        </p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <x-core-package::btn :href="route('studentDiscount.edit', $studentDiscount)" color="secondary">تعديل</x-core-package::btn>
        <x-core-package::btn :href="route('studentDiscount.index')" color="ghost">رجوع</x-core-package::btn>
    </div>
</div>

<x-core-package::card title="تفاصيل الإسناد" style="max-width:36rem;">
    <dl style="display:flex;flex-direction:column;gap:.875rem;">
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">التلميذ</dt>
            <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">{{ $studentDiscount->student?->first_name }} {{ $studentDiscount->student?->last_name }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">التخفيض</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">
                {{ $studentDiscount->discount?->discount_name }}
                ({{ $studentDiscount->discount?->discount_type === 'Percentage' ? $studentDiscount->discount?->discount_amount.'%' : 'دج'.number_format($studentDiscount->discount?->discount_amount ?? 0, 2) }})
            </dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">هيكل الرسوم المطبق</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">
                {{ $studentDiscount->feeStructure?->feeCategory?->category_name ?? '—' }}
                — {{ $studentDiscount->feeStructure?->schoolClass?->class_name ?? '' }}
            </dd>
        </div>
    </dl>
</x-core-package::card>

@endsection
