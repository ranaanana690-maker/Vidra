<div style="max-width:760px;margin:0 auto;">

    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0 0 1.5rem;">{{ $title }}</h1>

    @if($errors->any())
    <x-core-package::alert type="error" style="margin-bottom:1.25rem;">
        <ul style="margin:0;padding-left:1.25rem;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </x-core-package::alert>
    @endif

    <form method="POST" action="{{ $action }}" style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        <x-core-package::card title="معلومات القاعة">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.select name="hostel_id" label="مرقد" required>
                    <option value="">— اختر المرقد —</option>
                    @foreach($hostels as $h)
                    <option value="{{ $h->hostel_id }}"
                        @selected((string) old('hostel_id', $room->hostel_id ?? '') === (string) $h->hostel_id)>
                        {{ $h->hostel_name }} ({{ $h->hostel_type }})
                    </option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.input
                    name="room_number" label="رقم الغرفة" required
                    placeholder="مثال: 101"
                    value="{{ old('room_number', $room->room_number ?? '') }}" />

                <x-core-package::form.select name="room_type" label="نوع القاعة" required>
                    <option value="">— اختر النوع —</option>
                    @foreach(['Single','Double','Triple','Quad'] as $t)
                    <option value="{{ $t }}" @selected(old('room_type', $room->room_type ?? '') === $t)>{{ $t == 'Single' ? 'فردية' : ($t == 'Double' ? 'ثنائية' : ($t == 'Triple' ? 'ثلاثية' : 'رباعية')) }}</option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.input
                    name="capacity" label="السعة" type="number" required
                    placeholder="عدد الأسرّة"
                    value="{{ old('capacity', $room->capacity ?? '') }}" />

                <x-core-package::form.input
                    name="occupied" label="مشغول" type="number"
                    placeholder="الأسرّة المشغولة حالياً"
                    value="{{ old('occupied', $room->occupied ?? 0) }}" />
            </div>
        </x-core-package::card>

        <div style="display:flex;gap:.75rem;">
            <x-core-package::btn type="submit" color="primary">
                {{ isset($room) ? 'تحديث القاعة' : 'إنشاء قاعة' }}
            </x-core-package::btn>
            <x-core-package::btn :href="route('hostel-rooms.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</div>
