@php
$qualificationRows = old('qualifications', $staffMember?->qualifications?->toArray() ?: [['degree' => '', 'specialization' => '', 'university_name' => '', 'year_of_completion' => '']]);
$assignmentRows    = old('teacher_assignments', $staffMember?->teacherAssignments?->toArray() ?: [['class_name' => '', 'subject' => '']]);
@endphp

<div style="max-width:900px;margin:0 auto;">

    <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0 0 1.5rem;">{{ $title }}</h1>

    @if($errors->any())
    <x-core-package::alert type="error" style="margin-bottom:1.25rem;">
        <ul style="margin:0;padding-left:1.25rem;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </x-core-package::alert>
    @endif

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data"
          style="display:flex;flex-direction:column;gap:1.25rem;">
        @csrf
        @if($method !== 'POST') @method($method) @endif

        {{-- Core Staff Information --}}
        <x-core-package::card title="المعلومات الأساسية للطاقم">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.input
                    name="first_name" label="الاسم" required
                    value="{{ old('first_name', $staffMember->first_name ?? '') }}" />
                <x-core-package::form.input
                    name="last_name" label="اللقب" required
                    value="{{ old('last_name', $staffMember->last_name ?? '') }}" />
                <x-core-package::form.input
                    name="date_of_birth" label="تاريخ الميلاد" type="date"
                    value="{{ old('date_of_birth', optional($staffMember?->date_of_birth)->format('Y-m-d')) }}" />
                <x-core-package::form.select name="gender" label="الجنس" placeholder="اختر">
                    @foreach(['Male','Female','Other'] as $g)
                    <option value="{{ $g }}" @selected(old('gender', $staffMember->gender ?? '') === $g)>{{ $g == 'Male' ? 'ذكر' : ($g == 'Female' ? 'أنثى' : 'أخرى') }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input
                    name="phone_number" label="رقم الهاتف"
                    value="{{ old('phone_number', $staffMember->phone_number ?? '') }}" />
                <x-core-package::form.input
                    name="email" label="البريد الإلكتروني" type="email"
                    value="{{ old('email', $staffMember->email ?? '') }}" />
                <x-core-package::form.input
                    name="nationality" label="الجنسية"
                    value="{{ old('nationality', $staffMember->nationality ?? '') }}" />
                <x-core-package::form.file-upload
                    name="photo"
                    label="الصورة الشخصية"
                    accept="image/jpeg,image/png,image/gif,image/webp"
                    preview="{{ old('photo', $staffMember->photo ?? '') }}" />
                <div style="grid-column:1/-1;">
                    <x-core-package::form.textarea
                        name="address" label="العنوان" rows="2">{{ old('address', $staffMember->address ?? '') }}</x-core-package::form.textarea>
                </div>
            </div>
        </x-core-package::card>

        {{-- Employment Details --}}
        <x-core-package::card title="تفاصيل العمل">
            <div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:1rem;">
                <x-core-package::form.input
                    name="joining_date" label="تاريخ الالتحاق" type="date"
                    value="{{ old('joining_date', optional($staffMember?->joining_date)->format('Y-m-d')) }}" />
                <x-core-package::form.select name="department_id" label="القسم الإداري" placeholder="اختر القسم الإداري">
                    @foreach($departments as $department)
                    <option value="{{ $department->department_id }}"
                        @selected((string) old('department_id', $staffMember->department_id ?? '') === (string) $department->department_id)>
                        {{ $department->department_name }}
                    </option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input
                    name="designation" label="الوظيفة"
                    value="{{ old('designation', $staffMember->designation ?? '') }}"
                    hint="e.g. Teacher, Librarian, Accountant" />
                <x-core-package::form.select name="employment_type" label="نوع التوظيف" placeholder="اختر">
                    @foreach(['Permanent','Temporary','Contract'] as $type)
                    <option value="{{ $type }}" @selected(old('employment_type', $staffMember->employment_type ?? '') === $type)>{{ $type == 'Permanent' ? 'دائم' : ($type == 'Temporary' ? 'مؤقت' : 'متعاقد') }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="status" label="الحالة">
                    @foreach(['Active','Inactive','Resigned'] as $s)
                    <option value="{{ $s }}" @selected(old('status', $staffMember->status ?? 'Active') === $s)>{{ $s == 'Active' ? 'نشط' : ($s == 'Inactive' ? 'غير نشط' : 'مستقيل') }}</option>
                    @endforeach
                </x-core-package::form.select>
            </div>
        </x-core-package::card>

        {{-- Qualifications --}}
        <x-core-package::card title="المؤهلات">
            <div id="qualification-container" style="display:flex;flex-direction:column;gap:.875rem;">
                @foreach($qualificationRows as $index => $row)
                <div class="qual-row" style="border:1px dashed #d1d5db;border-radius:.5rem;padding:1rem;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;">
                    <x-core-package::form.input
                        name="qualifications[{{ $index }}][degree]" label="الشهادة"
                        value="{{ $row['degree'] ?? '' }}" />
                    <x-core-package::form.input
                        name="qualifications[{{ $index }}][specialization]" label="التخصص"
                        value="{{ $row['specialization'] ?? '' }}" />
                    <x-core-package::form.input
                        name="qualifications[{{ $index }}][university_name]" label="الجامعة / المؤسسة"
                        value="{{ $row['university_name'] ?? '' }}" />
                    <x-core-package::form.input
                        name="qualifications[{{ $index }}][year_of_completion]" label="سنة الإتمام" type="number"
                        value="{{ $row['year_of_completion'] ?? '' }}" />
                </div>
                @endforeach
            </div>
            <div style="margin-top:1rem;">
                <x-core-package::btn type="button" color="success" size="sm" onclick="addQualification()">
                    <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    إضافة مؤهل
                </x-core-package::btn>
            </div>
        </x-core-package::card>

        {{-- Teacher Assignments --}}
        <x-core-package::card title="إسناد الأساتذة">
            <div id="assignment-container" style="display:flex;flex-direction:column;gap:.875rem;">
                @foreach($assignmentRows as $index => $row)
                <div class="assign-row" style="border:1px dashed #d1d5db;border-radius:.5rem;padding:1rem;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;">
                    <x-core-package::form.input
                        name="teacher_assignments[{{ $index }}][class_name]" label="القسم / المستوى"
                        value="{{ $row['class_name'] ?? '' }}" />
                    <x-core-package::form.input
                        name="teacher_assignments[{{ $index }}][subject]" label="المادة"
                        value="{{ $row['subject'] ?? '' }}" />
                </div>
                @endforeach
            </div>
            <div style="margin-top:1rem;">
                <x-core-package::btn type="button" color="success" size="sm" onclick="addAssignment()">
                    <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    إضافة إسناد
                </x-core-package::btn>
            </div>
        </x-core-package::card>

        {{-- Form actions --}}
        <div style="display:flex;gap:.75rem;align-items:center;">
            <x-core-package::btn type="submit" color="primary">حفظ عضو الطاقم</x-core-package::btn>
            <x-core-package::btn :href="route('staff.index')" color="secondary">إلغاء</x-core-package::btn>
        </div>

    </form>
</div>

<script>
let qualificationIndex = {{ count($qualificationRows) }};
let assignmentIndex    = {{ count($assignmentRows) }};

function addQualification() {
    const i   = qualificationIndex++;
    const row = `<div class="qual-row" style="border:1px dashed #d1d5db;border-radius:.5rem;padding:1rem;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;">
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">الشهادة</label><input type="text" name="qualifications[${i}][degree]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">التخصص</label><input type="text" name="qualifications[${i}][specialization]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">الجامعة / المؤسسة</label><input type="text" name="qualifications[${i}][university_name]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">سنة الإتمام</label><input type="number" name="qualifications[${i}][year_of_completion]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
    </div>`;
    document.getElementById('qualification-container').insertAdjacentHTML('beforeend', row);
}

function addAssignment() {
    const i   = assignmentIndex++;
    const row = `<div class="assign-row" style="border:1px dashed #d1d5db;border-radius:.5rem;padding:1rem;display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:.75rem;">
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">القسم / المستوى</label><input type="text" name="teacher_assignments[${i}][class_name]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
        <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">المادة</label><input type="text" name="teacher_assignments[${i}][subject]" style="display:block;width:100%;border-radius:.5rem;border:1px solid #d1d5db;background:#fff;padding:.5rem .75rem;font-size:.8125rem;color:#111827;box-sizing:border-box;"></div>
    </div>`;
    document.getElementById('assignment-container').insertAdjacentHTML('beforeend', row);
}
</script>
