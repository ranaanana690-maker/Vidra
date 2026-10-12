@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('period.index') }}" style="color:#64748b;text-decoration:none;">الحصص</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">إضافة حصة</span>
</nav>
@endsection

@section('content')

<div style="max-width:480px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة حصة</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تحديد خانة زمنية جديدة</p>
    </div>

    <x-core-package::card>
        <form method="POST" action="{{ route('period.store') }}">
            @csrf
            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <x-core-package::form.input name="start_time" label="وقت البداية" type="time" required
                    value="{{ old('start_time') }}" />

                <x-core-package::form.input name="end_time" label="وقت النهاية" type="time" required
                    value="{{ old('end_time') }}" />

                @if($errors->any())
                <x-core-package::alert type="error">
                    <ul style="margin:0;padding-left:1rem;">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-core-package::alert>
                @endif

                <div style="display:flex;gap:.75rem;">
                    <x-core-package::btn type="submit" color="primary">حفظ الحصة</x-core-package::btn>
                    <x-core-package::btn :href="route('period.index')" color="secondary">إلغاء</x-core-package::btn>
                </div>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
