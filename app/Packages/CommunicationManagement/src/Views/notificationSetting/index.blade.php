@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">إعدادات الإشعارات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إعدادات الإشعارات</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إدارة إعدادات قنوات إشعارات المستخدمين</p>
    </div>
    <x-core-package::btn :href="route('notificationSetting.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>إضافة الإعدادات</x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('notificationSetting.index') }}"
          style="display:grid;grid-template-columns:1fr auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث باسم المستخدم" type="text" value="{{ request('search') }}" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">بحث</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('notificationSetting.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">#</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المستخدم</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">رسالة نصية</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">البريد الإلكتروني</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التطبيق</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الإعلانات</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المناشير</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;color:#94a3b8;font-size:.75rem;">{{ $item->setting_id }}</td>
                <td style="padding:.75rem 1rem;">
                    <p style="font-weight:600;color:#1e293b;margin:0;">{{ $item->user?->name ?? '#'.$item->user_id }}</p>
                    <p style="font-size:.75rem;color:#64748b;margin:.125rem 0 0;">{{ $item->user?->email }}</p>
                </td>
                @foreach(['allow_sms','allow_email','allow_app','allow_announcements','allow_circulars'] as $pref)
                <td style="padding:.75rem 1rem;text-align:center;">
                    @if($item->$pref)
                        <x-core-package::badge color="green">مفعّل</x-core-package::badge>
                    @else
                        <x-core-package::badge color="red">معطّل</x-core-package::badge>
                    @endif
                </td>
                @endforeach
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        <x-core-package::btn :href="route('notificationSetting.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('notificationSetting.destroy', $item) }}" onsubmit="return confirm('حذف هذه الإعدادات؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا توجد إعدادات مهيأة بعد.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
