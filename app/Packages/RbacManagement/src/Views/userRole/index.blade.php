@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">إسناد أدوار المستخدم</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إسناد أدوار المستخدم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إسناد الأدوار لمستخدمي النظام</p>
    </div>
    <x-core-package::btn :href="route('users.create')" color="primary">+ إنشاء مستخدم</x-core-package::btn>
</div>

@if(session('success'))
<x-core-package::alert type="success">{{ session('success') }}</x-core-package::alert>
@endif

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('user-roles.index') }}"
          style="display:flex;gap:.75rem;align-items:flex-end;">
        <div style="flex:1;">
            <x-core-package::form.input name="search" label="بحث عن المستخدمين" type="text"
                :value="request('search')" placeholder="الاسم أو البريد..." />
        </div>
        <div style="padding-top:1.375rem;display:flex;gap:.5rem;">
            <x-core-package::btn type="submit" color="primary">بحث</x-core-package::btn>
            <x-core-package::btn :href="route('user-roles.index')" color="secondary">إعادة تعيين</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">#</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المستخدم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">البريد الإلكتروني</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الأدوار المسندة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $user)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;color:#94a3b8;font-size:.75rem;">{{ $user->id }}</td>
                <td style="padding:.75rem 1rem;">
                    <span style="font-weight:600;color:#1e293b;">{{ $user->name }}</span>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $user->email }}</td>
                <td style="padding:.75rem 1rem;">
                    @forelse($user->roles as $role)
                    <x-core-package::badge color="indigo">{{ $role->name }}</x-core-package::badge>
                    @empty
                    <span style="color:#94a3b8;font-size:.75rem;">لا يوجد أدوار</span>
                    @endforelse
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <x-core-package::btn :href="route('user-roles.edit', $user)" color="primary" size="sm">إسناد الأدوار</x-core-package::btn>
                        <x-core-package::btn :href="route('user-permissions.edit', $user)" color="secondary" size="sm">صلاحيات مباشرة</x-core-package::btn>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد مستخدمون.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
