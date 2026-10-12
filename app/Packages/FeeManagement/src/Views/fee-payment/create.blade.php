@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('feePayment.index') }}" style="color:#64748b;text-decoration:none;">مدفوعات الرسوم</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">تسجيل دفعة</span>
</nav>
@endsection

@section('content')

<div style="max-width:44rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تسجيل دفعة</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تسجيل معاملة دفع رسوم</p>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('feePayment.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <x-core-package::form.select name="student_fee_id" label="رسم التلميذ" required>
                <option value="">اختر رسم التلميذ...</option>
                @foreach($studentFees as $sf)
                <option value="{{ $sf->student_fee_id }}"
                    @selected(old('student_fee_id', $selectedStudentFeeId) == $sf->student_fee_id)>
                    {{ $sf->student?->first_name }} {{ $sf->student?->last_name }}
                    — {{ $sf->feeStructure?->feeCategory?->category_name }}
                    (Balance: دج{{ number_format($sf->total_payable - $sf->payments->sum('amount_paid'), 2) }})
                </option>
                @endforeach
            </x-core-package::form.select>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="payment_date" label="تاريخ الدفع" type="date" required value="{{ old('payment_date', now()->format('Y-m-d')) }}" />
                <x-core-package::form.input name="amount_paid" label="المبلغ المدفوع (دج)" type="number" required value="{{ old('amount_paid') }}" />
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="payment_mode" label="طريقة الدفع" required>
                    <option value="">اختر الطريقة...</option>
                    @foreach(['Cash','CCP','BaridiMob','Bank Transfer'] as $mode)
                    <option value="{{ $mode }}" @selected(old('payment_mode') === $mode)>{{ $mode }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input name="transaction_reference" label="مرجع المعاملة" hint="رقم الإيصال/المعاملة اختياري" value="{{ old('transaction_reference') }}" />
            </div>
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">تسجيل دفعة</x-core-package::btn>
                <x-core-package::btn :href="route('feePayment.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
