@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('user-roles.index') }}" style="color:#0ea5e9;">أدوار المستخدمين</a>
    <span style="color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">إنشاء مستخدم</span>
</nav>
@endsection

@section('content')

<div style="max-width:32rem;margin:0 auto;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إنشاء مستخدم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إضافة مستخدم جديد للنظام</p>
    </div>

    @if($errors->any())
    <x-core-package::alert type="error">
        <ul style="margin:0;padding-left:1.25rem;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-core-package::alert>
    @endif

    <x-core-package::card>
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div style="margin-bottom:1.25rem;">
                <x-core-package::form.input
                    name="name"
                    label="الاسم الكامل"
                    type="text"
                    placeholder="محمد أحمد"
                    :value="old('name')"
                    required
                />
            </div>

            <div style="margin-bottom:1.25rem;">
                <x-core-package::form.input
                    name="email"
                    label="البريد الإلكتروني"
                    type="email"
                    placeholder="john@example.com"
                    :value="old('email')"
                    required
                />
            </div>

            <div style="margin-bottom:1.25rem;">
                <x-core-package::form.input
                    name="password"
                    label="كلمة المرور"
                    type="password"
                    placeholder="8 أحرف على الأقل"
                    required
                />
            </div>

            <div style="margin-bottom:1.5rem;">
                <x-core-package::form.input
                    name="password_confirmation"
                    label="تأكيد كلمة المرور"
                    type="password"
                    placeholder="أعد إدخال كلمة المرور"
                    required
                />
            </div>

            <div style="display:flex;gap:.75rem;">
                <x-core-package::btn type="submit" color="primary">إنشاء مستخدم</x-core-package::btn>
                <x-core-package::btn :href="route('user-roles.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
