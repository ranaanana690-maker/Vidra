@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('feeStructure.index') }}" style="color:#64748b;text-decoration:none;">هياكل الرسوم</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">التفاصيل</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تفاصيل هيكل الرسوم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">{{ $feeStructure->targetLabel() }} — {{ $feeStructure->feeCategory?->category_name }}</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <x-core-package::btn :href="route('feeStructure.edit', $feeStructure)" color="secondary">تعديل</x-core-package::btn>
        <x-core-package::btn :href="route('feeStructure.index')" color="ghost">رجوع</x-core-package::btn>
    </div>
</div>

<x-core-package::card title="معلومات الهيكل" style="max-width:36rem;">
    <dl style="display:grid;grid-template-columns:1fr 1fr;gap:.875rem;">
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">الموجه إليه</dt>
            <dd style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">{{ $feeStructure->targetLabel() }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">الدورية</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">{{ $feeStructure->frequency === 'monthly' ? 'شهري'.($feeStructure->billing_month ? ' · '.$feeStructure->billing_month : '') : 'مرة واحدة' }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">الصنف</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">{{ $feeStructure->feeCategory?->category_name ?? '—' }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">السنة الدراسية</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">{{ $feeStructure->academicYear?->year_range ?? '—' }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">تاريخ الاستحقاق</dt>
            <dd style="font-size:.875rem;color:#475569;margin:0;">{{ $feeStructure->due_date?->format('d M Y') ?? '—' }}</dd>
        </div>
        <div>
            <dt style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin-bottom:.2rem;">المبلغ</dt>
            <dd style="font-size:1.25rem;font-weight:700;color:#0f766e;margin:0;">دج{{ number_format($feeStructure->amount, 2) }}</dd>
        </div>
    </dl>
</x-core-package::card>

@endsection
