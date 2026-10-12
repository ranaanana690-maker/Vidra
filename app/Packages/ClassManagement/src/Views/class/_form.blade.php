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

        <x-core-package::card title="معلومات القسم">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.input
                    name="class_name" label="اسم القسم" required
                    placeholder="e.g. Grade 1, Class 10"
                    value="{{ old('class_name', $schoolClass->class_name ?? '') }}" />
                <x-core-package::form.input
                    name="class_code" label="رمز القسم"
                    placeholder="رمز فريد اختياري"
                    value="{{ old('class_code', $schoolClass->class_code ?? '') }}" />
                <x-core-package::form.select name="academic_year_id" label="السنة الدراسية" placeholder="اختر السنة الدراسية">
                    <option value="">— بدون —</option>
                    @foreach($academicYears as $year)
                    <option value="{{ $year->academic_year_id }}"
                        @selected((string) old('academic_year_id', $schoolClass->academic_year_id ?? '') === (string) $year->academic_year_id)>
                        {{ $year->year_range }}
                        @if($year->is_current) (الحالي) @endif
                    </option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="level" label="الطور" placeholder="اختر الطور">
                    <option value="">— بدون —</option>
                    @foreach($levels as $code => $label)
                    <option value="{{ $code }}"
                        @selected(old('level', $schoolClass->level ?? '') === $code)>
                        {{ $label }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="stream" label="الشعبة (للثانوي فقط)" placeholder="اختر الشعبة">
                    <option value="">— بدون —</option>
                    @foreach($streams as $code => $label)
                    <option value="{{ $code }}"
                        @selected(old('stream', $schoolClass->stream ?? '') === $code)>
                        {{ $label }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
                <div style="display:flex;align-items:center;gap:.625rem;padding-top:1.5rem;">
                    <label style="display:flex;align-items:center;gap:.625rem;cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1"
                               style="width:1rem;height:1rem;accent-color:#4f46e5;"
                               {{ old('is_active', $schoolClass->is_active ?? true) ? 'checked' : '' }}>
                        <span style="font-size:.875rem;font-weight:500;color:#374151;">نشط</span>
                    </label>
                </div>
                <div style="grid-column:1/-1;">
                    <x-core-package::form.textarea
                        name="description" label="الوصف" rows="3"
                        placeholder="معلومات إضافية اختيارية">{{ old('description', $schoolClass->description ?? '') }}</x-core-package::form.textarea>
                </div>
            </div>
        </x-core-package::card>

        <div style="display:flex;gap:.75rem;">
            <x-core-package::btn type="submit" color="primary">
                {{ isset($schoolClass) ? 'تحديث القسم' : 'إنشاء قسم' }}
            </x-core-package::btn>
            <x-core-package::btn :href="route('classes.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>

    </form>
</div>
