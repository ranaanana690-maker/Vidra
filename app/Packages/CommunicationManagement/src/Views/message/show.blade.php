@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('message.index') }}" style="color:#64748b;text-decoration:none;">الرسائل</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">Message #{{ $message->message_id }}</span>
</nav>
@endsection

@section('content')

@php
    $typeColors = ['SMS'=>'blue','Email'=>'indigo','App Notification'=>'purple','Circular'=>'orange','Announcement'=>'green'];
    $prioColors = ['Low'=>'gray','Normal'=>'blue','High'=>'yellow','Urgent'=>'red'];
@endphp

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">
        {{ $message->title ?: 'Message #'.$message->message_id }}
    </h1>
    <div style="display:flex;gap:.5rem;">
        <x-core-package::btn :href="route('message.edit', $message)" color="secondary">تعديل</x-core-package::btn>
        <form method="POST" action="{{ route('message.destroy', $message) }}" onsubmit="return confirm('حذف هذه الرسالة؟')">
            @csrf @method('DELETE')
            <x-core-package::btn type="submit" color="danger">حذف</x-core-package::btn>
        </form>
    </div>
</div>

<div style="display:grid;grid-template-columns:2fr 1fr;gap:1.25rem;">

    <div>
        <x-core-package::card title="تفاصيل الرسالة" style="margin-bottom:1.25rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">النوع</p>
                    <x-core-package::badge color="{{ $typeColors[$message->message_type] ?? 'gray' }}">{{ $message->message_type }}</x-core-package::badge>
                </div>
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">الأولوية</p>
                    <x-core-package::badge color="{{ $prioColors[$message->priority] ?? 'gray' }}">{{ $message->priority }}</x-core-package::badge>
                </div>
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">الحالة</p>
                    @if($message->is_sent)
                        <x-core-package::badge color="green">مرسل</x-core-package::badge>
                    @else
                        <x-core-package::badge color="gray">معلق</x-core-package::badge>
                    @endif
                </div>
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">المرسل</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $message->sender?->name ?? '— النظام —' }}</p>
                </div>
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">أُنشئ</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $message->created_at->format('d M Y, H:i') }}</p>
                </div>
                @if($message->scheduled_at)
                <div>
                    <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .25rem;">وقت الجدولة</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $message->scheduled_at->format('d M Y, H:i') }}</p>
                </div>
                @endif
            </div>
            <div>
                <p style="font-size:.7rem;font-weight:600;color:#94a3b8;text-transform:uppercase;margin:0 0 .5rem;">المحتوى</p>
                <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:.5rem;padding:1rem;font-size:.875rem;color:#374151;white-space:pre-wrap;line-height:1.6;">{{ $message->content }}</div>
            </div>
        </x-core-package::card>

        <x-core-package::card title="Recipients ({{ $message->recipients->count() }})" :noPadding="true">
            <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:.5rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">المستلم</th>
                        <th style="padding:.5rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">الحالة</th>
                        <th style="padding:.5rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">تم التسليم</th>
                        <th style="padding:.5rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;border-bottom:1px solid #e2e8f0;">مقروء</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($message->recipients as $r)
                @php $statusColors = ['Pending'=>'gray','Sent'=>'blue','Failed'=>'red','Read'=>'green']; @endphp
                <tr style="border-bottom:1px solid #f1f5f9;">
                    <td style="padding:.625rem 1rem;color:#1e293b;">{{ $r->user?->name ?? '#'.$r->user_id }}</td>
                    <td style="padding:.625rem 1rem;"><x-core-package::badge color="{{ $statusColors[$r->status] ?? 'gray' }}">{{ $r->status }}</x-core-package::badge></td>
                    <td style="padding:.625rem 1rem;color:#64748b;">{{ $r->delivered_at?->format('d M Y H:i') ?? '—' }}</td>
                    <td style="padding:.625rem 1rem;color:#64748b;">{{ $r->read_at?->format('d M Y H:i') ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding:1.5rem;text-align:center;color:#94a3b8;">لا يوجد مستلمون بعد.</td></tr>
                @endforelse
                </tbody>
            </table>
        </x-core-package::card>
    </div>

    <div>
        <x-core-package::card title="إجراءات سريعة">
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                <x-core-package::btn :href="route('messageRecipient.create').'?message_id='.$message->message_id" color="primary" size="sm">إضافة مستلم</x-core-package::btn>
                <x-core-package::btn :href="route('message.index')" color="secondary" size="sm">رجوع إلى القائمة</x-core-package::btn>
            </div>
        </x-core-package::card>
    </div>
</div>

@endsection
