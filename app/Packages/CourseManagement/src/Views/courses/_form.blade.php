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

        <x-core-package::card title="معلومات الدورة">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.input
                    name="name" label="اسم الدورة" required
                    placeholder="مثال: القرآن الكريم، الإنجليزية، السوروبان"
                    value="{{ old('name', $course->name ?? '') }}" />
                <x-core-package::form.input
                    name="code" label="رمز الدورة"
                    placeholder="رمز فريد اختياري"
                    value="{{ old('code', $course->code ?? '') }}" />
                <x-core-package::form.select name="category" label="الصنف" placeholder="اختر الصنف" required>
                    @foreach($categories as $code => $label)
                    <option value="{{ $code }}"
                        @selected(old('category', $course->category ?? 'other') === $code)>
                        {{ $label }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input
                    name="price" label="السعر (الدورة كاملة)" type="number" step="0.01" min="0"
                    placeholder="0.00"
                    value="{{ old('price', $course->price ?? '0') }}" />
                <x-core-package::form.input
                    name="duration_weeks" label="المدة (أسابيع)" type="number" min="1"
                    placeholder="اختياري"
                    value="{{ old('duration_weeks', $course->duration_weeks ?? '') }}" />
                <div style="display:flex;align-items:center;gap:.625rem;padding-top:1.5rem;">
                    <label style="display:flex;align-items:center;gap:.625rem;cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1"
                               style="width:1rem;height:1rem;accent-color:#4f46e5;"
                               {{ old('is_active', $course->is_active ?? true) ? 'checked' : '' }}>
                        <span style="font-size:.875rem;font-weight:500;color:#374151;">نشط</span>
                    </label>
                </div>
                <div style="grid-column:1/-1;">
                    <x-core-package::form.textarea
                        name="description" label="الوصف" rows="3"
                        placeholder="معلومات إضافية اختيارية">{{ old('description', $course->description ?? '') }}</x-core-package::form.textarea>
                </div>
            </div>
        </x-core-package::card>

        <div style="display:flex;gap:.75rem;">
            <x-core-package::btn type="submit" color="primary">
                {{ isset($course) ? 'تحديث الدورة' : 'إنشاء دورة' }}
            </x-core-package::btn>
            <x-core-package::btn :href="route('courses.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>

    </form>
</div>
