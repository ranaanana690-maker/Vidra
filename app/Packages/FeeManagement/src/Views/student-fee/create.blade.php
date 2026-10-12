@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('studentFee.index') }}" style="color:#64748b;text-decoration:none;">رسوم التلاميذ</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إسناد رسم</span>
</nav>
@endsection

@section('content')

<div style="max-width:48rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إسناد رسم لتلميذ</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إنشاء سجل التزام رسوم لتلميذ</p>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('studentFee.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <x-core-package::form.select name="student_id" label="التلميذ" required>
                    <option value="">اختر التلميذ...</option>
                    @foreach($students as $student)
                    <option value="{{ $student->student_id }}" @selected(old('student_id') == $student->student_id)>{{ $student->first_name }} {{ $student->last_name }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="fee_structure_id" label="هيكل رسوم" required>
                    <option value="">اختر هيكل الرسوم...</option>
                    @foreach($feeStructures as $fs)
                    <option value="{{ $fs->fee_structure_id }}" @selected(old('fee_structure_id') == $fs->fee_structure_id)>
                        {{ $fs->feeCategory?->category_name }} — {{ $fs->targetLabel() }} ({{ $fs->academicYear?->year_range }}) · دج{{ number_format($fs->amount, 2) }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
                <x-core-package::form.input name="amount_due" label="المبلغ المستحق (دج)" type="number" required value="{{ old('amount_due') }}" />
                <x-core-package::form.input name="discount_amount" label="التخفيض (دج)" type="number" hint="0 إذا لا يوجد" value="{{ old('discount_amount', 0) }}" />
                <x-core-package::form.input name="penalty_amount" label="الغرامة (دج)" type="number" hint="0 إذا لا يوجد" value="{{ old('penalty_amount', 0) }}" />
            </div>
            <x-core-package::form.input name="due_date" label="تاريخ الاستحقاق" type="date" required value="{{ old('due_date') }}" />
            <x-core-package::form.input name="billing_period" label="شهر الفوترة (YYYY-MM، للشهري)" placeholder="مثال: 2026-10" value="{{ old('billing_period') }}" />
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">إسناد رسم</x-core-package::btn>
                <x-core-package::btn :href="route('studentFee.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
