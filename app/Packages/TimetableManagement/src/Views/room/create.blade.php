@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('room.index') }}" style="color:#64748b;text-decoration:none;">القاعات</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">إضافة قاعة</span>
</nav>
@endsection

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إضافة قاعة</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تسجيل قاعة أو فضاء جديد</p>
    </div>

    <x-core-package::card>
        <form method="POST" action="{{ route('room.store') }}">
            @csrf
            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <x-core-package::form.input name="room_name" label="اسم القاعة" required
                    hint="e.g. 101, Physics Lab, Main Auditorium"
                    value="{{ old('room_name') }}" />

                <x-core-package::form.select name="room_type" label="نوع القاعة" required>
                    <option value="">اختر النوع</option>
                    @foreach(['Classroom','Lab','Auditorium','Office'] as $type)
                    <option value="{{ $type }}" @selected(old('room_type') === $type)>{{ $type == 'Classroom' ? 'قاعة دراسية' : ($type == 'Lab' ? 'مخبر' : ($type == 'Auditorium' ? 'قاعة كبرى' : 'مكتب')) }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.input name="capacity" label="السعة" type="number" required
                    hint="Maximum number of students"
                    value="{{ old('capacity') }}" />

                <x-core-package::form.textarea name="description" label="الوصف" rows="3"
                    hint="Optional notes about this room">{{ old('description') }}</x-core-package::form.textarea>

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
                    <x-core-package::btn type="submit" color="primary">حفظ القاعة</x-core-package::btn>
                    <x-core-package::btn :href="route('room.index')" color="secondary">إلغاء</x-core-package::btn>
                </div>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
