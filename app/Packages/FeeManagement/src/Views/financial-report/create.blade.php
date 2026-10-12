@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('financialReport.index') }}" style="color:#64748b;text-decoration:none;">التقارير المالية</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إنشاء تقرير</span>
</nav>
@endsection

@section('content')

<div style="max-width:40rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إنشاء تقرير مالي</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">يحسب مجموع المداخيل أو المصاريف لفترة محددة</p>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('financialReport.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <x-core-package::form.select name="report_type" label="نوع التقرير" required>
                <option value="">اختر النوع...</option>
                <option value="Income" @selected(old('report_type') === 'Income')>المداخيل (مدفوعات الرسوم)</option>
                <option value="Expense" @selected(old('report_type') === 'Expense')>المصاريف (مصاريف المدرسة)</option>
            </x-core-package::form.select>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="report_period_start" label="بداية الفترة" type="date" required value="{{ old('report_period_start') }}" />
                <x-core-package::form.input name="report_period_end" label="نهاية الفترة" type="date" required value="{{ old('report_period_end') }}" />
            </div>
            <x-core-package::alert type="info">
                سيجمع النظام تلقائيا كل معاملات النوع المحدد ضمن هذا النطاق الزمني.
            </x-core-package::alert>
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">إنشاء تقرير</x-core-package::btn>
                <x-core-package::btn :href="route('financialReport.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
