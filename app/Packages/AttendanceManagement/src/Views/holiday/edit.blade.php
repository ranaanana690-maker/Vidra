@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('holiday.index') }}" style="color:#374151;font-weight:500;text-decoration:none;">العطل</a>
    <span style="margin:0 .375rem;color:#94a3b8;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل العطلة</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل العطلة</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تحديث تفاصيل العطلة</p>
    </div>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('holiday.update', $holiday) }}">
        @csrf
        @method('PUT')

        <x-core-package::form.input name="title" label="عنوان العطلة" value="{{ old('title', $holiday->title) }}" required />
        
        <x-core-package::form.input name="date" label="التاريخ" type="date" value="{{ old('date', $holiday->date->format('Y-m-d')) }}" required />
        
        <x-core-package::form.textarea name="description" label="الوصف" rows="3">{{ old('description', $holiday->description) }}</x-core-package::form.textarea>
        
        <x-core-package::form.select name="is_recurring" label="متكررة">
            <option value="0" @selected(!$holiday->is_recurring)>لمرة واحدة</option>
            <option value="1" @selected($holiday->is_recurring)>تتكرر كل سنة</option>
        </x-core-package::form.select>

        <div style="display:flex;gap:.75rem;margin-top:1.5rem;">
            <x-core-package::btn type="submit" color="primary">تحديث العطلة</x-core-package::btn>
            <x-core-package::btn :href="route('holiday.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

@endsection