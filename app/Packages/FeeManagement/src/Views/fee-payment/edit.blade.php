@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('feePayment.index') }}" style="color:#64748b;text-decoration:none;">مدفوعات الرسوم</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل الدفعة</span>
</nav>
@endsection

@section('content')

<div style="max-width:44rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل الدفعة</h1>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('feePayment.update', $feePayment) }}">
        @csrf @method('PUT')
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <x-core-package::form.select name="student_fee_id" label="رسم التلميذ" required>
                <option value="">اختر رسم التلميذ...</option>
                @foreach($studentFees as $sf)
                <option value="{{ $sf->student_fee_id }}" @selected(old('student_fee_id', $feePayment->student_fee_id) == $sf->student_fee_id)>
                    {{ $sf->student?->first_name }} {{ $sf->student?->last_name }}
                    — {{ $sf->feeStructure?->feeCategory?->category_name }}
                </option>
                @endforeach
            </x-core-package::form.select>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="payment_date" label="تاريخ الدفع" type="date" required value="{{ old('payment_date', $feePayment->payment_date?->format('Y-m-d')) }}" />
                <x-core-package::form.input name="amount_paid" label="المبلغ المدفوع (دج)" type="number" required value="{{ old('amount_paid', $feePayment->amount_paid) }}" />
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="payment_mode" label="طريقة الدفع" required>
                    <option value="">اختر الطريقة...</option>
                    @foreach(['Cash','CCP','BaridiMob','Bank Transfer'] as $mode)
                    <option value="{{ $mode }}" @selected(old('payment_mode', $feePayment->payment_mode) === $mode)>{{ $mode }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input name="transaction_reference" label="مرجع المعاملة" value="{{ old('transaction_reference', $feePayment->transaction_reference) }}" />
            </div>
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">تحديث الدفعة</x-core-package::btn>
                <x-core-package::btn :href="route('feePayment.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
