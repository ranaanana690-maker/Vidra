@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('messageRecipient.index') }}" style="color:#64748b;text-decoration:none;">المستلمون</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة مستلم</span>
</nav>
@endsection

@section('content')

<div style="max-width:600px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة مستلم</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تعيين مستلم لرسالة</p>
    </div>

    @if($errors->any())
    <x-core-package::alert type="error" style="margin-bottom:1rem;">
        <ul style="margin:0;padding-left:1.25rem;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </x-core-package::alert>
    @endif

    <x-core-package::card>
        <form method="POST" action="{{ route('messageRecipient.store') }}">
            @csrf

            <div style="margin-bottom:1rem;">
                <x-core-package::form.select name="message_id" label="رسالة" required>
                    <option value="">اختر الرسالة...</option>
                    @foreach($messages as $msg)
                    <option value="{{ $msg->message_id }}" @selected(old('message_id', request('message_id')) == $msg->message_id)>
                        #{{ $msg->message_id }} — {{ Str::limit($msg->title ?: $msg->content, 60) }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
            </div>

            <div style="margin-bottom:1rem;">
                <x-core-package::form.select name="user_id" label="المستلم" required>
                    <option value="">اختر المستخدم...</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </x-core-package::form.select>
            </div>

            <div style="margin-bottom:1rem;">
                <x-core-package::form.select name="status" label="حالة التسليم" required>
                    @foreach(['Pending','Sent','Failed','Read'] as $s)
                    <option value="{{ $s }}" @selected(old('status', 'Pending') === $s)>{{ $s == 'Pending' ? 'معلق' : ($s == 'Sent' ? 'مرسل' : ($s == 'Failed' ? 'فشل' : 'مقروء')) }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                <x-core-package::form.input name="delivered_at" label="وقت التسليم" type="datetime-local"
                    value="{{ old('delivered_at') }}" />
                <x-core-package::form.input name="read_at" label="وقت القراءة" type="datetime-local"
                    value="{{ old('read_at') }}" />
            </div>

            <div style="display:flex;gap:.75rem;">
                <x-core-package::btn type="submit" color="primary">إضافة مستلم</x-core-package::btn>
                <x-core-package::btn :href="route('messageRecipient.index')" color="secondary">إلغاء</x-core-package::btn>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
