@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('alumni.events.index') }}" style="color:#64748b;text-decoration:none;">الفعاليات</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">إنشاء فعالية</span>
</nav>
@endsection

@section('content')

<div style="max-width:720px;margin:0 auto;">

<div style="margin-bottom:1.5rem;">
    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إنشاء فعالية للخريجين</h1>
</div>

<x-core-package::card>
    <form method="POST" action="{{ route('alumni.events.store') }}">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
            <div style="grid-column:1/-1;">
                <x-core-package::form.input name="title" label="عنوان الفعالية" :value="old('title')" required />
                @error('title')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>
            <div>
                <x-core-package::form.select name="event_type" label="نوع الفعالية" required>
                    @foreach(['reunion','webinar','workshop','social'] as $type)
                    <option value="{{ $type }}" {{ old('event_type') === $type ? 'selected' : '' }}>{{ ['reunion'=>'لقاء','webinar'=>'ندوة','workshop'=>'ورشة','social'=>'اجتماع'][$type] ?? ucfirst($type) }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>
            <div>
                <x-core-package::form.select name="status" label="الحالة" required>
                    @foreach(['upcoming','ongoing','completed','cancelled'] as $s)
                    <option value="{{ $s }}" {{ old('status','upcoming') === $s ? 'selected' : '' }}>{{ ['upcoming'=>'قادمة','ongoing'=>'جارية','completed'=>'مكتملة','cancelled'=>'ملغاة'][$s] ?? ucfirst($s) }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>
            <div>
                <x-core-package::form.input name="event_date" label="تاريخ ووقت الفعالية" type="datetime-local" :value="old('event_date')" required />
                @error('event_date')<div style="color:#dc2626;font-size:.75rem;margin-top:.25rem;">{{ $message }}</div>@enderror
            </div>
            <div>
                <x-core-package::form.input name="venue" label="المكان" :value="old('venue')" placeholder="المكان أو رابط online" />
            </div>
            <div>
                <x-core-package::form.input name="max_attendees" label="الحد الأقصى للحاضرين" type="number" :value="old('max_attendees')" placeholder="اتركه فارغًا لعدد غير محدود" />
            </div>
            <div>
                <x-core-package::form.input name="registration_deadline" label="آخر أجل للتسجيل" type="date" :value="old('registration_deadline')" />
            </div>
            <div>
                <x-core-package::form.select name="organizer_alumni_id" label="المنظم (خريج)">
                    <option value="">المدرسة / الإدارة</option>
                    @foreach($alumni as $a)
                    <option value="{{ $a->id }}" {{ old('organizer_alumni_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->full_name }} ({{ $a->graduation_year }})
                    </option>
                    @endforeach
                </x-core-package::form.select>
            </div>
        </div>

        <div style="margin-bottom:1.25rem;">
            <x-core-package::form.textarea name="description" label="الوصف" rows="4" :value="old('description')" />
        </div>

        <div style="display:flex;gap:.75rem;justify-content:flex-end;">
            <x-core-package::btn :href="route('alumni.events.index')" color="secondary">إلغاء</x-core-package::btn>
            <x-core-package::btn type="submit" color="primary">إنشاء الفعالية</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

</div>
@endsection
