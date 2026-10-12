@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('roles.index') }}" style="color:#64748b;text-decoration:none;">الأدوار</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">Edit {{ $role->name }}</span>
</nav>
@endsection

@section('content')

<div style="max-width:640px;">

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل الدور</h1>
    <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تحديث تفاصيل الدور</p>
</div>

@if($errors->any())
<x-core-package::alert type="error" style="margin-bottom:1rem;">
    <ul style="margin:0;padding-left:1.25rem;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</x-core-package::alert>
@endif

<x-core-package::card>
    <form method="POST" action="{{ route('roles.update', $role) }}">
        @csrf @method('PUT')
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <x-core-package::form.input name="name" label="اسم الدور" type="text" required
                :value="old('name', $role->name)" />

            <x-core-package::form.textarea name="description" label="الوصف" rows="3"
                hint="وصف اختياري لما يمكن لهذا الدور فعله">{{ old('description', $role->description) }}</x-core-package::form.textarea>

            <div style="display:flex;gap:.75rem;padding-top:.5rem;">
                <x-core-package::btn type="submit" color="primary">تحديث الدور</x-core-package::btn>
                <x-core-package::btn :href="route('roles.show', $role)" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </div>
    </form>
</x-core-package::card>

</div>
@endsection
