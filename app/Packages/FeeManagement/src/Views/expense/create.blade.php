@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('expense.index') }}" style="color:#64748b;text-decoration:none;">المصاريف</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة مصروف</span>
</nav>
@endsection

@section('content')

<div style="max-width:40rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة مصروف</h1>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('expense.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="expense_date" label="تاريخ المصروف" type="date" required value="{{ old('expense_date', now()->format('Y-m-d')) }}" />
                <x-core-package::form.input name="amount" label="المبلغ (دج)" type="number" required value="{{ old('amount') }}" />
            </div>
            <x-core-package::form.input name="expense_category" label="الصنف" required placeholder="مثال: صيانة، رواتب، مرافق" value="{{ old('expense_category') }}" />
            <x-core-package::form.textarea name="description" label="الوصف" rows="3" hint="ملاحظات اختيارية" value="{{ old('description') }}" />
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">حفظ المصروف</x-core-package::btn>
                <x-core-package::btn :href="route('expense.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
