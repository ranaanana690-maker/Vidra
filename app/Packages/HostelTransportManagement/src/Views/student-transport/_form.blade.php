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

        <x-core-package::card title="إسناد النقل">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.input
                    name="student_id" label="معرف التلميذ" type="number" required
                    placeholder="أدخل معرف التلميذ"
                    value="{{ old('student_id', $studentTransport->student_id ?? '') }}" />

                <x-core-package::form.select name="transport_id" label="خدمة النقل" required>
                    <option value="">— اختر الخدمة —</option>
                    @foreach($transports as $t)
                    <option value="{{ $t->transport_id }}"
                        @selected((string) old('transport_id', $studentTransport->transport_id ?? '') === (string) $t->transport_id)>
                        {{ $t->transport_name }} ({{ $t->transport_type }})
                    </option>
                    @endforeach
                </x-core-package::form.select>

                <x-core-package::form.input
                    name="pickup_location" label="مكان الصعود"
                    placeholder="مثال: الباب الرئيسي"
                    value="{{ old('pickup_location', $studentTransport->pickup_location ?? '') }}" />

                <x-core-package::form.input
                    name="drop_location" label="مكان النزول"
                    placeholder="مثال: الجناح الدراسي"
                    value="{{ old('drop_location', $studentTransport->drop_location ?? '') }}" />

                <x-core-package::form.input
                    name="assigned_date" label="تاريخ الإسناد" type="date" required
                    value="{{ old('assigned_date', isset($studentTransport) ? $studentTransport->assigned_date?->format('Y-m-d') : '') }}" />

                <x-core-package::form.input
                    name="leave_date" label="تاريخ المغادرة" type="date"
                    hint="Leave empty if still using the service"
                    value="{{ old('leave_date', isset($studentTransport) ? $studentTransport->leave_date?->format('Y-m-d') : '') }}" />
            </div>
        </x-core-package::card>

        <div style="display:flex;gap:.75rem;">
            <x-core-package::btn type="submit" color="primary">
                {{ isset($studentTransport) ? 'تحديث الإسناد' : 'إنشاء الإسناد' }}
            </x-core-package::btn>
            <x-core-package::btn :href="route('student-transport.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>
    </form>
</div>
