@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('students.index') }}" style="color:#94a3b8;text-decoration:none;" onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">التلاميذ</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">{{ $student->first_name }} {{ $student->last_name }}</span>
</nav>
@endsection

@section('content')

@php
$statusColor = match($student->status) {
    'Active'      => 'green',
    'Inactive'    => 'yellow',
    'Graduated'   => 'blue',
    'Transferred' => 'orange',
    default       => 'gray',
};
$initials = strtoupper(substr($student->first_name,0,1).substr($student->last_name,0,1));
@endphp

{{-- Page header --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div style="display:flex;align-items:center;gap:1rem;">
        @if($student->profile_photo)
        <img src="{{ $student->profile_photo }}" alt="{{ $student->first_name }}"
             style="width:3.5rem;height:3.5rem;border-radius:50%;object-fit:cover;border:3px solid #e2e8f0;flex-shrink:0;">
        @else
        <div style="width:3.5rem;height:3.5rem;background:linear-gradient(135deg,#4f46e5,#6366f1);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <span style="font-size:1.125rem;font-weight:700;color:#fff;">{{ $initials }}</span>
        </div>
        @endif
        <div>
            <div style="display:flex;align-items:center;gap:.625rem;">
                <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">{{ $student->first_name }} {{ $student->last_name }}</h1>
                <x-core-package::badge :color="$statusColor">{{ $student->status }}</x-core-package::badge>
            </div>
            <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">التسجيل {{ $student->admission_number }} &middot; الالتحاق: {{ optional($student->date_of_admission)->format('M d, Y') }}</p>
        </div>
    </div>
    <div style="display:flex;gap:.5rem;flex-shrink:0;padding-top:.25rem;">
        <x-core-package::btn :href="route('students.edit', $student)" color="primary" size="sm">
            <svg style="width:.8rem;height:.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            تعديل
        </x-core-package::btn>
        <x-core-package::btn :href="route('students.index')" color="secondary" size="sm">رجوع</x-core-package::btn>
    </div>
</div>

{{-- Two-column layout --}}
<div style="display:grid;grid-template-columns:minmax(0,1fr) 22rem;gap:1.25rem;align-items:start;">

    {{-- ── Left column ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Personal Info --}}
        <x-core-package::card title="المعلومات الشخصية">
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem .25rem;">
                @php
                function infoRow(string $label, $value): void {
                    echo '<div style="padding:.625rem .5rem;">'
                       . '<p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">' . e($label) . '</p>'
                       . '<p style="font-size:.875rem;font-weight:500;color:#1e293b;margin:0;overflow-wrap:anywhere;">' . (trim((string)$value) ?: '<span style="color:#cbd5e1;">—</span>') . '</p>'
                       . '</div>';
                }
                @endphp
                @php infoRow('الاسم', $student->first_name); @endphp
                @php infoRow('اللقب',  $student->last_name); @endphp
                @php infoRow('تاريخ الميلاد', optional($student->date_of_birth)->format('M d, Y')); @endphp
                @php infoRow('الجنس', $student->gender); @endphp
                @php infoRow('زمرة الدم', $student->blood_group); @endphp
                @php infoRow('الجنسية', $student->nationality); @endphp
                @php infoRow('Religion', $student->religion); @endphp
                @php infoRow('الهاتف', $student->phone_number); @endphp
                @php infoRow('البريد الإلكتروني', $student->email); @endphp
                <div style="grid-column:1/-1;padding:.625rem .5rem;">
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">العنوان الحالي</p>
                    <p style="font-size:.875rem;font-weight:500;color:#1e293b;margin:0;">{{ $student->current_address }}</p>
                </div>
                <div style="grid-column:1/-1;padding:.625rem .5rem;">
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">العنوان الدائم</p>
                    <p style="font-size:.875rem;font-weight:500;color:#1e293b;margin:0;">{{ $student->permanent_address }}</p>
                </div>
            </div>
        </x-core-package::card>

        {{-- Parent Info --}}
        @if($student->parentInfo)
        <x-core-package::card title="معلومات الأولياء / الوصي">
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem .25rem;">
                @php infoRow('الأب', $student->parentInfo->father_name); @endphp
                @php infoRow('هاتف الأب', $student->parentInfo->father_phone); @endphp
                @php infoRow('بريد الأب', $student->parentInfo->father_email); @endphp
                @php infoRow('مهنة الأب', $student->parentInfo->father_occupation); @endphp
                @php infoRow('الأم', $student->parentInfo->mother_name); @endphp
                @php infoRow('هاتف الأم', $student->parentInfo->mother_phone); @endphp
                @php infoRow('بريد الأم', $student->parentInfo->mother_email); @endphp
                @php infoRow('مهنة الأم', $student->parentInfo->mother_occupation); @endphp
                @if($student->parentInfo->guardian_name)
                @php infoRow('الوصي', $student->parentInfo->guardian_name); @endphp
                @php infoRow('هاتف الوصي', $student->parentInfo->guardian_phone); @endphp
                @php infoRow('صلة القرابة', $student->parentInfo->guardian_relationship); @endphp
                <div style="grid-column:1/-1;padding:.625rem .5rem;">
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">عنوان الوصي</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $student->parentInfo->guardian_address ?: '—' }}</p>
                </div>
                @endif
            </div>
        </x-core-package::card>
        @endif

        {{-- Enrollments --}}
        @if($student->enrollments && $student->enrollments->count())
        <x-core-package::card title="التسجيلات" :noPadding="true">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الدفعة</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">السنة الدراسية</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ التسجيل</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($student->enrollments as $enrollment)
                    @php $eColor = $enrollment->status === 'Active' ? 'green' : 'gray'; @endphp
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:.75rem 1.25rem;font-weight:500;color:#1e293b;">{{ $enrollment->batch->batch_name ?? '—' }}</td>
                        <td style="padding:.75rem 1rem;color:#64748b;">{{ $enrollment->academicYear->year_range ?? '—' }}</td>
                        <td style="padding:.75rem 1rem;color:#64748b;">{{ optional($enrollment->enrollment_date)->format('M d, Y') }}</td>
                        <td style="padding:.75rem 1rem;"><x-core-package::badge :color="$eColor">{{ $enrollment->status }}</x-core-package::badge></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-core-package::card>
        @endif

        {{-- Promotion History --}}
        @if($student->promotionHistory && $student->promotionHistory->count())
        <x-core-package::card title="سجل الترقيات" :noPadding="true">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">من</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إلى</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التاريخ</th>
                            <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">ملاحظات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($student->promotionHistory as $promo)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:.75rem 1.25rem;color:#64748b;">{{ $promo->fromBatch->batch_name ?? $promo->from_batch_id }}</td>
                        <td style="padding:.75rem 1rem;font-weight:500;color:#1e293b;">{{ $promo->toBatch->batch_name ?? $promo->to_batch_id }}</td>
                        <td style="padding:.75rem 1rem;color:#64748b;">{{ optional($promo->promotion_date)->format('M d, Y') }}</td>
                        <td style="padding:.75rem 1rem;color:#64748b;">{{ $promo->remarks ?: '—' }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </x-core-package::card>
        @endif

        {{-- Previous Education --}}
        @if($student->previousEducations && $student->previousEducations->count())
        <x-core-package::card title="التعليم السابق">
            <div style="display:flex;flex-direction:column;gap:.75rem;">
                @foreach($student->previousEducations as $edu)
                <div style="border:1px solid #e2e8f0;border-radius:.5rem;padding:.875rem 1rem;background:#fafafa;">
                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $edu->school_name }}</p>
                    <p style="font-size:.75rem;color:#64748b;margin:.25rem 0 0;">
                        {{ $edu->board }}
                        @if($edu->class_completed) &middot; Class {{ $edu->class_completed }} @endif
                        @if($edu->percentage) &middot; {{ $edu->percentage }}% @endif
                        @if($edu->year_of_passing) &middot; {{ $edu->year_of_passing }} @endif
                    </p>
                </div>
                @endforeach
            </div>
        </x-core-package::card>
        @endif

        {{-- Health Records --}}
        @if($student->healthRecord)
        <x-core-package::card title="المعلومات الصحية">
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:1rem .25rem;">
                @php infoRow('الطول', $student->healthRecord->height_cm ? $student->healthRecord->height_cm.' سم' : null); @endphp
                @php infoRow('الوزن', $student->healthRecord->weight_kg ? $student->healthRecord->weight_kg.' كغ' : null); @endphp
                @php infoRow('زمرة الدم', $student->healthRecord->blood_group); @endphp
                @php infoRow('حالة التطعيم', $student->healthRecord->vaccination_status); @endphp
                <div style="grid-column:1/-1;padding:.625rem .5rem;">
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">الحساسية</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $student->healthRecord->allergies ?: 'None' }}</p>
                </div>
                <div style="grid-column:1/-1;padding:.625rem .5rem;">
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">الحالات المرضية</p>
                    <p style="font-size:.875rem;color:#1e293b;margin:0;">{{ $student->healthRecord->medical_conditions ?: 'None' }}</p>
                </div>
            </div>
        </x-core-package::card>
        @endif

        {{-- Contacts --}}
        @if($student->contacts && $student->contacts->count())
        <x-core-package::card title="جهات اتصال إضافية">
            <div style="display:flex;flex-direction:column;gap:.625rem;">
                @foreach($student->contacts as $contact)
                <div style="display:flex;align-items:center;justify-content:space-between;border:1px solid #e2e8f0;border-radius:.5rem;padding:.75rem 1rem;background:#fafafa;">
                    <div>
                        <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $contact->contact_value }}</p>
                        <p style="font-size:.7rem;color:#64748b;margin:.125rem 0 0;">{{ ucfirst($contact->contact_type) }}{{ $contact->label ? ' · '.$contact->label : '' }}</p>
                    </div>
                    @if($contact->is_primary)
                    <x-core-package::badge color="indigo">رئيسي</x-core-package::badge>
                    @endif
                </div>
                @endforeach
            </div>
        </x-core-package::card>
        @endif

        {{-- Documents --}}
        @if($student->documents && $student->documents->count())
        <x-core-package::card title="الوثائق">
            <div style="display:flex;flex-direction:column;gap:.625rem;">
                @foreach($student->documents as $doc)
                <div style="display:flex;align-items:center;gap:.875rem;border:1px solid #e2e8f0;border-radius:.5rem;padding:.75rem 1rem;background:#fafafa;">
                    <div style="width:2rem;height:2rem;background:#eef2ff;border-radius:.375rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg style="width:1rem;height:1rem;color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $doc->document_name }}</p>
                        <p style="font-size:.7rem;color:#64748b;margin:.125rem 0 0;">{{ ucwords(str_replace('_',' ',$doc->document_type)) }} &middot; {{ $doc->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </x-core-package::card>
        @endif

        {{-- Activity Logs --}}
        @if($student->activityLogs && $student->activityLogs->count())
        <x-core-package::card title="سجل النشاطات">
            <div style="display:flex;flex-direction:column;gap:.5rem;">
                @foreach($student->activityLogs->take(10) as $log)
                <div style="border-left:3px solid #6366f1;padding:.5rem 0 .5rem .875rem;">
                    <p style="font-size:.8125rem;font-weight:600;color:#1e293b;margin:0;">{{ ucwords(str_replace('_',' ',$log->activity_type)) }}</p>
                    <p style="font-size:.7rem;color:#64748b;margin:.125rem 0 0;">{{ $log->description }} &middot; {{ $log->created_at->diffForHumans() }}</p>
                </div>
                @endforeach
            </div>
        </x-core-package::card>
        @endif

    </div>{{-- end left column --}}

    {{-- ── Right sidebar ── --}}
    <div style="display:flex;flex-direction:column;gap:1.25rem;">

        {{-- Quick Info --}}
        <x-core-package::card title="معلومات سريعة">
            <div style="display:flex;flex-direction:column;gap:.875rem;">
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">رقم التسجيل</p>
                    <p style="font-size:.9375rem;font-weight:700;color:#1e293b;margin:0;">{{ $student->admission_number }}</p>
                </div>
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .375rem;">الحالة</p>
                    <x-core-package::badge :color="$statusColor">{{ $student->status }}</x-core-package::badge>
                </div>
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">تاريخ التسجيل</p>
                    <p style="font-size:.875rem;font-weight:500;color:#1e293b;margin:0;">{{ optional($student->date_of_admission)->format('M d, Y') }}</p>
                </div>
            </div>
        </x-core-package::card>

        {{-- Enroll in Batch --}}
        <x-core-package::card title="التسجيل في دفعة">
            <form method="POST" action="{{ route('students.enroll.store', $student) }}" style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <x-core-package::form.select name="batch_id" label="الدفعة" required placeholder="اختر الدفعة">
                    @foreach($batches as $batch)
                    <option value="{{ $batch->batch_id }}">{{ $batch->batch_name }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.select name="academic_year_id" label="السنة الدراسية" placeholder="اختر السنة الدراسية">
                    @foreach($academicYears as $year)
                    <option value="{{ $year->academic_year_id }}">{{ $year->year_range }}</option>
                    @endforeach
                </x-core-package::form.select>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    <x-core-package::form.input name="enrollment_date" label="التاريخ" required type="date" :value="date('Y-m-d')" />
                    <x-core-package::form.select name="status" label="الحالة">
                        @foreach(['Active','Inactive','Graduated','Transferred'] as $s)
                        <option value="{{ $s }}">{{ $s == 'Active' ? 'نشط' : ($s == 'Inactive' ? 'غير نشط' : ($s == 'Graduated' ? 'متخرج' : 'محول')) }}</option>
                        @endforeach
                    </x-core-package::form.select>
                </div>
                <x-core-package::form.textarea name="remarks" label="ملاحظات" rows="2" />
                <x-core-package::btn type="submit" color="success">تسجيل التلميذ</x-core-package::btn>
            </form>
        </x-core-package::card>

        {{-- Promote Student --}}
        <x-core-package::card title="ترقية التلميذ">
            <form method="POST" action="{{ route('students.promote.store', $student) }}" style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    <x-core-package::form.select name="from_batch_id" label="من الدفعة" required placeholder="من">
                        @foreach($batches as $batch)<option value="{{ $batch->batch_id }}">{{ $batch->batch_name }}</option>@endforeach
                    </x-core-package::form.select>
                    <x-core-package::form.select name="to_batch_id" label="إلى الدفعة" required placeholder="إلى">
                        @foreach($batches as $batch)<option value="{{ $batch->batch_id }}">{{ $batch->batch_name }}</option>@endforeach
                    </x-core-package::form.select>
                </div>
                <x-core-package::form.input name="promotion_date" label="تاريخ الترقية" required type="date" :value="date('Y-m-d')" />
                <x-core-package::form.textarea name="remarks" label="ملاحظات" rows="2" />
                <x-core-package::btn type="submit" color="primary">ترقية التلميذ</x-core-package::btn>
            </form>
        </x-core-package::card>

        {{-- Add Document --}}
        <x-core-package::card title="إضافة وثيقة">
            <form method="POST" action="{{ route('students.documents.store', $student) }}"
                  enctype="multipart/form-data"
                  style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <x-core-package::form.select name="document_type" label="نوع الوثيقة" required>
                    @foreach(['birth_certificate','transfer_certificate','character_certificate','previous_school_certificate','medical_certificate','passport','id_proof','address_proof','photograph','other'] as $dtype)
                    <option value="{{ $dtype }}">{{ ucwords(str_replace('_',' ',$dtype)) }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input name="document_name" label="اسم الوثيقة" required />
                <x-core-package::form.file-upload
                    name="file_path"
                    label="رفع الوثيقة"
                    accept="image/*,application/pdf,.doc,.docx,.xls,.xlsx"
                    hint="PDF أو صور أو Word أو Excel — بحد أقصى 10 م.ب"
                    required />
                <x-core-package::form.input name="expiry_date" label="تاريخ الانتهاء" type="date" />
                <x-core-package::btn type="submit" color="warning">حفظ الوثيقة</x-core-package::btn>
            </form>
        </x-core-package::card>

        {{-- Add Health Log --}}
        <x-core-package::card title="إضافة سجل صحي">
            <form method="POST" action="{{ route('students.health.store', $student) }}" style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                    <x-core-package::form.input name="height_cm" label="الطول (سم)" type="number" step="0.1" />
                    <x-core-package::form.input name="weight_kg" label="الوزن (كغ)" type="number" step="0.1" />
                </div>
                <x-core-package::form.input name="blood_group"        label="زمرة الدم"        :value="$student->blood_group" />
                <x-core-package::form.input name="medical_conditions" label="الحالات المرضية" />
                <x-core-package::form.input name="vaccination_status" label="حالة التطعيم" />
                <x-core-package::btn type="submit" color="blue">حفظ السجل الصحي</x-core-package::btn>
            </form>
        </x-core-package::card>

        {{-- Add Contact --}}
        <x-core-package::card title="إضافة جهة اتصال">
            <form method="POST" action="{{ route('students.contacts.store', $student) }}" style="display:flex;flex-direction:column;gap:.75rem;">
                @csrf
                <x-core-package::form.select name="contact_type" label="النوع" required>
                    @foreach(['phone','mobile','emergency','work','fax','other'] as $t)
                    <option value="{{ $t }}">{{ $t == 'phone' ? 'الهاتف' : ($t == 'mobile' ? 'المحمول' : ($t == 'emergency' ? 'الطوارئ' : ($t == 'work' ? 'العمل' : ($t == 'fax' ? 'الفاكس' : 'أخرى')))) }}</option>
                    @endforeach
                </x-core-package::form.select>
                <x-core-package::form.input name="contact_value" label="الاتصال" required />
                <x-core-package::form.input name="label"         label="التسمية"   placeholder="e.g. Home" />
                <label style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:#374151;cursor:pointer;">
                    <input type="checkbox" name="is_primary" value="1" style="width:1rem;height:1rem;accent-color:#4f46e5;">
                    تعيين كجهة اتصال رئيسية
                </label>
                <x-core-package::btn type="submit" color="dark">حفظ جهة الاتصال</x-core-package::btn>
            </form>
        </x-core-package::card>

        {{-- Danger zone --}}
        <x-core-package::card title="منطقة الخطر">
            <form method="POST" action="{{ route('students.destroy', $student) }}">
                @csrf @method('DELETE')
                <p style="font-size:.75rem;color:#64748b;margin:0 0 .875rem;">حذف هذا التلميذ نهائيًا وجميع السجلات المرتبطة به. لا يمكن التراجع عن هذا الإجراء.</p>
                <x-core-package::btn type="submit" color="danger"
                    onclick="return confirm('حذف {{ $student->first_name }} {{ $student->last_name }} نهائيًا؟ لا يمكن التراجع عن هذا الإجراء.')">
                    حذف التلميذ
                </x-core-package::btn>
            </form>
        </x-core-package::card>

    </div>{{-- end sidebar --}}

</div>{{-- end two-column --}}

@endsection
