@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('specialEvent.index') }}" style="color:#64748b;text-decoration:none;">المناسبات</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">تعديل المناسبة</span>
</nav>
@endsection

@section('content')

<div style="max-width:640px;">
    <div style="margin-bottom:1.5rem;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">تعديل المناسبة</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">{{ $specialEvent->event_name }}</p>
    </div>

    <x-core-package::card>
        <form method="POST" action="{{ route('specialEvent.update', $specialEvent) }}">
            @csrf @method('PUT')
            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                <x-core-package::form.input name="event_name" label="اسم المناسبة" required
                    value="{{ old('event_name', $specialEvent->event_name) }}" />

                <x-core-package::form.input name="event_date" label="تاريخ المناسبة" type="date" required
                    value="{{ old('event_date', $specialEvent->event_date?->format('Y-m-d')) }}" />

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
                    <x-core-package::form.input name="start_time" label="وقت البداية" type="time" required
                        value="{{ old('start_time', \Illuminate\Support\Str::substr($specialEvent->start_time, 0, 5)) }}" />
                    <x-core-package::form.input name="end_time" label="وقت النهاية" type="time" required
                        value="{{ old('end_time', \Illuminate\Support\Str::substr($specialEvent->end_time, 0, 5)) }}" />
                </div>

                <x-core-package::form.select name="room_id" label="القاعة (اختياري)">
                    <option value="">بدون قاعة محددة</option>
                    @foreach($rooms as $room)
                    <option value="{{ $room->room_id }}" @selected(old('room_id', $specialEvent->room_id) == $room->room_id)>{{ $room->room_name }} ({{ $room->room_type }}, cap: {{ $room->capacity }})</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.textarea name="description" label="الوصف" rows="3">{{ old('description', $specialEvent->description) }}</x-core-package::form.textarea>

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
                    <x-core-package::btn type="submit" color="primary">تحديث المناسبة</x-core-package::btn>
                    <x-core-package::btn :href="route('specialEvent.index')" color="secondary">إلغاء</x-core-package::btn>
                </div>
            </div>
        </form>
    </x-core-package::card>
</div>

@endsection
