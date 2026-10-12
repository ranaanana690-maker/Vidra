@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('students.index') }}" style="color:#94a3b8;text-decoration:none;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">التلاميذ</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة تلميذ</span>
</nav>
@endsection

@section('content')

<x-core-package::page-header
    title="إضافة تلميذ جديد"
    subtitle="املأ جميع المعلومات المطلوبة لتسجيل تلميذ جديد."
    :back="route('students.index')"
/>

@if($errors->any())
<x-core-package::alert type="error" title="يرجى تصحيح الأخطاء التالية قبل الحفظ:">
    <ul style="margin:.375rem 0 0;padding-left:1rem;list-style:disc;">
        @foreach($errors->all() as $error)
        <li style="font-size:.75rem;margin-bottom:.125rem;">{{ $error }}</li>
        @endforeach
    </ul>
</x-core-package::alert>
@endif

<form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
@csrf

{{-- ── 1. Basic Information ── --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <x-core-package::form.section title="المعلومات الأساسية" description="البيانات الشخصية وبيانات الاتصال بالتلميذ.">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            <x-core-package::form.input name="first_name" label="الاسم" required :value="old('first_name')" placeholder="e.g. Ravi" />
            <x-core-package::form.input name="last_name"  label="اللقب"  required :value="old('last_name')"  placeholder="e.g. Kumar" />

            <x-core-package::form.input name="date_of_birth" label="تاريخ الميلاد" required type="date" :value="old('date_of_birth')" />

            <x-core-package::form.select name="gender" label="الجنس" required placeholder="اختر الجنس">
                @foreach(['Male','Female','Other'] as $g)
                <option value="{{ $g }}" {{ old('gender') == $g ? 'selected' : '' }}>{{ $g == 'Male' ? 'ذكر' : ($g == 'Female' ? 'أنثى' : 'أخرى') }}</option>
                @endforeach
            </x-core-package::form.select>

            <x-core-package::form.select name="blood_group" label="زمرة الدم" placeholder="اختر زمرة الدم">
                @foreach(['A+','A-','B+','B-','AB+','AB-','O+','O-'] as $bg)
                <option value="{{ $bg }}" {{ old('blood_group') == $bg ? 'selected' : '' }}>{{ $bg }}</option>
                @endforeach
            </x-core-package::form.select>

            <x-core-package::form.input name="nationality" label="الجنسية" :value="old('nationality')" placeholder="e.g. Indian" />

            <x-core-package::form.input name="religion" label="الديانة" :value="old('religion')" placeholder="e.g. Hindu" />

            <x-core-package::form.input name="phone_number" label="رقم الهاتف" :value="old('phone_number')" placeholder="e.g. +91-9876543210" />

            <x-core-package::form.input name="email" label="البريد الإلكتروني" type="email" :value="old('email')" placeholder="e.g. student@email.com" />

            {{-- Profile Photo --}}
            <x-core-package::form.file-upload
                name="profile_photo"
                label="الصورة الشخصية"
                accept="image/jpeg,image/png,image/gif,image/webp" />

            <div style="grid-column:1/-1;">
                <x-core-package::form.textarea name="current_address" label="العنوان الحالي" required rows="2" :value="old('current_address')" placeholder="العنوان الحالي الكامل" />
            </div>
            <div style="grid-column:1/-1;">
                <x-core-package::form.textarea name="permanent_address" label="العنوان الدائم" required rows="2" :value="old('permanent_address')" placeholder="العنوان الدائم (إذا كان نفس العنوان أعلاه، انسخه هنا)" />
            </div>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── 2. Admission Information ── --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <x-core-package::form.section title="معلومات التسجيل" description="تفاصيل التسجيل والحالة.">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            <x-core-package::form.input name="date_of_admission" label="تاريخ التسجيل" required type="date" :value="old('date_of_admission', date('Y-m-d'))" />
            <x-core-package::form.input name="admission_number" label="رقم التسجيل" required :value="old('admission_number')" placeholder="e.g. ADM-2026-001" />
            <x-core-package::form.select name="status" label="الحالة">
                @foreach(['Active','Inactive','Graduated','Transferred'] as $s)
                <option value="{{ $s }}" {{ old('status','Active') == $s ? 'selected' : '' }}>{{ $s == 'Active' ? 'نشط' : ($s == 'Inactive' ? 'غير نشط' : ($s == 'Graduated' ? 'متخرج' : 'محول')) }}</option>
                @endforeach
            </x-core-package::form.select>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── 3. Parent / Guardian ── --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <x-core-package::form.section title="معلومات الأولياء / الوصي" description="بيانات الاتصال بالأب والأم والوصي للطوارئ.">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            <x-core-package::form.input name="father_name"       label="اسم الأب"       :value="old('father_name')" />
            <x-core-package::form.input name="father_phone"      label="هاتف الأب"      :value="old('father_phone')" />
            <x-core-package::form.input name="father_email"      label="بريد الأب"      type="email" :value="old('father_email')" />
            <x-core-package::form.input name="father_occupation" label="مهنة الأب" :value="old('father_occupation')" />
            <x-core-package::form.input name="mother_name"       label="اسم الأم"       :value="old('mother_name')" />
            <x-core-package::form.input name="mother_phone"      label="هاتف الأم"      :value="old('mother_phone')" />
            <x-core-package::form.input name="mother_email"      label="بريد الأم"      type="email" :value="old('mother_email')" />
            <x-core-package::form.input name="mother_occupation" label="مهنة الأم" :value="old('mother_occupation')" />
            <div style="grid-column:1/-1;">
                <x-core-package::form.input name="guardian_name" label="اسم الوصي (إذا تعذّر حضور الوالدين)" :value="old('guardian_name')" />
            </div>
            <x-core-package::form.input name="guardian_relationship" label="صلة الوصي" :value="old('guardian_relationship')" placeholder="e.g. Uncle" />
            <x-core-package::form.input name="guardian_phone"        label="هاتف الوصي"        :value="old('guardian_phone')" />
            <div style="grid-column:1/-1;">
                <x-core-package::form.textarea name="guardian_address" label="عنوان الوصي" rows="2" :value="old('guardian_address')" />
            </div>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── 4. Previous Education ── --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <x-core-package::form.section title="التعليم السابق" description="أضف سجلًا مدرسيًا سابقًا أو أكثر.">
        <x-slot:action>
            <x-core-package::btn type="button" color="success" size="sm" onclick="addEducation()">
                <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                إضافة صف
            </x-core-package::btn>
        </x-slot:action>

        <div id="education-container" style="display:flex;flex-direction:column;gap:.875rem;">
            <div class="edu-row" style="border:1px dashed #cbd5e1;border-radius:.625rem;padding:1rem;background:#fafafa;">
                <input type="hidden" name="previous_educations_index[]" value="0">
                <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.875rem;">
                    <x-core-package::form.input name="previous_educations[0][school_name]" label="اسم المدرسة" placeholder="e.g. ABC High School" />
                    <x-core-package::form.input name="previous_educations[0][board]"        label="الهيئة"       placeholder="e.g. CBSE, ICSE" />
                    <x-core-package::form.input name="previous_educations[0][class_completed]" label="القسم المُكمل" placeholder="e.g. 10th" />
                    <x-core-package::form.input name="previous_educations[0][percentage]"   label="النسبة (%)" type="number" step="0.01" min="0" max="100" placeholder="e.g. 85.5" />
                    <x-core-package::form.input name="previous_educations[0][year_of_passing]" label="سنة الاجتياز" type="number" min="1990" max="{{ date('Y') }}" placeholder="e.g. 2023" />
                </div>
            </div>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── 5. Health Information ── --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <x-core-package::form.section title="المعلومات الصحية" description="البيانات الطبية وسجلات التطعيم.">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1.25rem;">
            <x-core-package::form.input name="height_cm" label="الطول (سم)" type="number" step="0.1" :value="old('height_cm')" placeholder="e.g. 165.5" />
            <x-core-package::form.input name="weight_kg" label="الوزن (كغ)" type="number" step="0.1" :value="old('weight_kg')" placeholder="e.g. 58.0" />
            <x-core-package::form.input name="allergies" label="الحساسية" :value="old('allergies')" placeholder="e.g. Peanuts, Dust" />
            <div style="grid-column:1/-1;">
                <x-core-package::form.input name="medical_conditions" label="الحالات المرضية" :value="old('medical_conditions')" placeholder="e.g. Asthma, Diabetes" />
            </div>
            <div style="grid-column:1/-1;">
                <x-core-package::form.input name="vaccination_status" label="حالة التطعيم" :value="old('vaccination_status')" placeholder="e.g. Up to date, Missing MMR" />
            </div>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── 6. Additional Contacts ── --}}
<x-core-package::card style="margin-bottom:1.5rem;">
    <x-core-package::form.section title="جهات اتصال إضافية" description="أرقام هواتف إضافية أو جهات اتصال للطوارئ.">
        <x-slot:action>
            <x-core-package::btn type="button" color="success" size="sm" onclick="addContact()">
                <svg style="width:.75rem;height:.75rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                إضافة جهة اتصال
            </x-core-package::btn>
        </x-slot:action>

        <div id="contact-container" style="display:flex;flex-direction:column;gap:.875rem;">
            <div class="contact-row" style="border:1px dashed #cbd5e1;border-radius:.625rem;padding:1rem;background:#fafafa;">
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.875rem;align-items:end;">
                    <x-core-package::form.select name="contacts[0][contact_type]" label="النوع">
                        @foreach(['phone','mobile','emergency','work','fax','other'] as $t)
                        <option value="{{ $t }}">{{ $t == 'phone' ? 'الهاتف' : ($t == 'mobile' ? 'المحمول' : ($t == 'emergency' ? 'الطوارئ' : ($t == 'work' ? 'العمل' : ($t == 'fax' ? 'الفاكس' : 'أخرى')))) }}</option>
                        @endforeach
                    </x-core-package::form.select>
                    <x-core-package::form.input name="contacts[0][contact_value]" label="الرقم / القيمة" placeholder="e.g. +91-9876543210" />
                    <x-core-package::form.input name="contacts[0][label]" label="التسمية" placeholder="e.g. Home, Emergency" />
                    <label style="display:flex;align-items:center;gap:.375rem;font-size:.8125rem;color:#374151;padding-bottom:.5rem;cursor:pointer;">
                        <input type="checkbox" name="contacts[0][is_primary]" value="1" style="width:1rem;height:1rem;accent-color:#4f46e5;">
                        رئيسي
                    </label>
                </div>
            </div>
        </div>
    </x-core-package::form.section>
</x-core-package::card>

{{-- ── Actions ── --}}
<div style="display:flex;gap:.75rem;padding:.25rem 0 1rem;">
    <x-core-package::btn type="submit" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        حفظ التلميذ
    </x-core-package::btn>
    <x-core-package::btn href="{{ route('students.index') }}" color="secondary">إلغاء</x-core-package::btn>
</div>

</form>
@endsection

@push('scripts')
<script>
let eduCount = 1;
let contactCount = 1;

function addEducation() {
    const c = document.getElementById('education-container');
    const i = eduCount++;
    const d = document.createElement('div');
    d.className = 'edu-row';
    d.style.cssText = 'border:1px dashed #cbd5e1;border-radius:.625rem;padding:1rem;background:#fafafa;position:relative;';
    d.innerHTML = `
        <button type="button" onclick="this.closest('.edu-row').remove()"
            style="position:absolute;top:.625rem;right:.625rem;background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;line-height:1;"
            onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#94a3b8'">
            <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <input type="hidden" name="previous_educations_index[]" value="${i}">
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:.875rem;">
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">اسم المدرسة</label>
            <input type="text" name="previous_educations[${i}][school_name]" placeholder="e.g. ABC High School" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">الهيئة</label>
            <input type="text" name="previous_educations[${i}][board]" placeholder="e.g. CBSE" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">القسم المُكمل</label>
            <input type="text" name="previous_educations[${i}][class_completed]" placeholder="e.g. 10th" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">النسبة (%)</label>
            <input type="number" step="0.01" name="previous_educations[${i}][percentage]" placeholder="e.g. 85.5" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">سنة الاجتياز</label>
            <input type="number" name="previous_educations[${i}][year_of_passing]" placeholder="e.g. 2023" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
        </div>`;
    c.appendChild(d);
}

function addContact() {
    const c = document.getElementById('contact-container');
    const i = contactCount++;
    const d = document.createElement('div');
    d.className = 'contact-row';
    d.style.cssText = 'border:1px dashed #cbd5e1;border-radius:.625rem;padding:1rem;background:#fafafa;position:relative;';
    d.innerHTML = `
        <button type="button" onclick="this.closest('.contact-row').remove()"
            style="position:absolute;top:.625rem;right:.625rem;background:none;border:none;cursor:pointer;color:#94a3b8;padding:0;line-height:1;"
            onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#94a3b8'">
            <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:.875rem;align-items:end;">
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">النوع</label>
            <select name="contacts[${i}][contact_type]" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;">
                <option value="phone">الهاتف</option><option value="mobile">المحمول</option><option value="emergency">الطوارئ</option><option value="work">العمل</option><option value="fax">الفاكس</option><option value="other">أخرى</option>
            </select></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">الرقم / القيمة</label>
            <input type="text" name="contacts[${i}][contact_value]" placeholder="e.g. +91-9876543210" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <div><label style="display:block;font-size:.8125rem;font-weight:500;color:#374151;margin-bottom:.375rem;">التسمية</label>
            <input type="text" name="contacts[${i}][label]" placeholder="e.g. Home" style="display:block;width:100%;border:1px solid #d1d5db;border-radius:.5rem;padding:.5rem .75rem;font-size:.8125rem;background:#fff;outline:none;box-sizing:border-box;"></div>
            <label style="display:flex;align-items:center;gap:.375rem;font-size:.8125rem;color:#374151;padding-bottom:.5rem;cursor:pointer;">
                <input type="checkbox" name="contacts[${i}][is_primary]" value="1" style="width:1rem;height:1rem;accent-color:#4f46e5;"> رئيسي
            </label>
        </div>`;
    c.appendChild(d);
}
</script>
@endpush
