@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('holiday.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">العطل</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة عطلة</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة عطلة</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إنشاء عطلة جديدة</p>
    </div>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('holiday.store') }}">
        @csrf

        <x-core-package::form.input name="title" label="عنوان العطلة" placeholder="مثال: عيد الاستقلال" required />
        
        <x-core-package::form.input name="date" label="التاريخ" type="date" required />
        
        <x-core-package::form.textarea name="description" label="الوصف" placeholder="وصف اختياري..." rows="3" />
        
        <x-core-package::form.select name="is_recurring" label="متكررة">
            <option value="0">لمرة واحدة</option>
            <option value="1">تتكرر كل سنة</option>
        </x-core-package::form.select>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <x-core-package::btn type="submit" color="primary">إنشاء عطلة</x-core-package::btn>
            <x-core-package::btn :href="route('holiday.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

@endsection