@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('feeCategory.index') }}" style="color:#64748b;text-decoration:none;">أصناف الرسوم</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة صنف</span>
</nav>
@endsection

@section('content')

<div style="max-width:40rem;">
<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة صنف رسوم</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">حدد صنف رسوم جديد (مثال: دراسة، نقل)</p>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('feeCategory.store') }}">
        @csrf
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <x-core-package::form.input name="category_name" label="اسم الصنف" required placeholder="مثال: رسوم الدراسة" value="{{ old('category_name') }}" />
            <x-core-package::form.textarea name="description" label="الوصف" rows="3" hint="وصف اختياري" value="{{ old('description') }}" />
            @if($errors->any())
            <x-core-package::alert type="error">{{ $errors->first() }}</x-core-package::alert>
            @endif
            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">حفظ الصنف</x-core-package::btn>
                <x-core-package::btn :href="route('feeCategory.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>
</div>

@endsection
