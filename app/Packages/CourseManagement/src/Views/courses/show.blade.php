@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('courses.index') }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">الدورات</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">{{ $course->name }}</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <div style="display:flex;align-items:center;gap:.625rem;">
            <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">{{ $course->name }}</h1>
            <x-core-package::badge :color="$course->is_active ? 'green' : 'gray'">
                {{ $course->is_active ? 'نشط' : 'غير نشط' }}
            </x-core-package::badge>
        </div>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">
            @if($course->code) الرمز: {{ $course->code }} &middot; @endif
            {{ \App\Packages\CourseManagement\Models\Course::CATEGORIES[$course->category] ?? $course->category }}
            @if($course->price > 0) &middot; السعر: {{ number_format($course->price, 2) }} @endif
            @if($course->duration_weeks) &middot; {{ $course->duration_weeks }} أسابيع @endif
        </p>
        @if($course->description)
        <p style="font-size:.8125rem;color:#475569;margin:.5rem 0 0;">{{ $course->description }}</p>
        @endif
    </div>
    <div style="display:flex;gap:.5rem;flex-shrink:0;padding-top:.25rem;">
        <x-core-package::btn :href="route('courses.edit', $course)" color="primary" size="sm">تعديل</x-core-package::btn>
        <x-core-package::btn :href="route('courses.index')" color="secondary" size="sm">رجوع</x-core-package::btn>
    </div>
</div>

{{-- Levels --}}
<x-core-package::card :noPadding="true" style="margin-bottom:1.25rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;">
        <p style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">الأطوار</p>
    </div>
    @if($course->levels->count())
    <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
        <tbody>
        @foreach($course->levels as $level)
        <tr style="border-bottom:1px solid #f1f5f9;">
            <td style="padding:.625rem 1.25rem;font-weight:600;color:#1e293b;">
                #{{ $level->level_order }} — {{ $level->level_name }}
            </td>
            <td style="padding:.625rem 1rem;">
                <form method="POST" action="{{ route('courses.levels.destroy', [$course, $level]) }}"
                      onsubmit="return confirm('حذف الطور {{ $level->level_name }}؟')"
                      style="display:inline;">
                    @csrf @method('DELETE')
                    <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p style="padding:1rem 1.25rem;color:#94a3b8;font-size:.8125rem;margin:0;">لا يوجد أطوار بعد.</p>
    @endif
    <form method="POST" action="{{ route('courses.levels.store', $course) }}"
          style="display:grid;grid-template-columns:1fr 120px auto;gap:.75rem;padding:1rem 1.25rem;border-top:1px solid #f1f5f9;align-items:end;">
        @csrf
        <x-core-package::form.input name="level_name" label="طور جديد" placeholder="مثال: الطور 1" required />
        <x-core-package::form.input name="level_order" label="الترتيب" type="number" min="0" value="0" />
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary" size="sm">إضافة طور</x-core-package::btn></div>
    </form>
</x-core-package::card>

{{-- Enrollments --}}
<x-core-package::card :noPadding="true" style="margin-bottom:1.25rem;">
    <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;">
        <p style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">التسجيلات ({{ $course->enrollments->count() }})</p>
    </div>
    @forelse($course->enrollments as $enrollment)
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;">
        <div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;">
            <div>
                <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">
                    {{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}
                    <span style="font-weight:400;color:#94a3b8;">({{ $enrollment->student->admission_number ?? '' }})</span>
                </p>
                <p style="font-size:.75rem;color:#64748b;margin:.25rem 0 0;">
                    الطور: {{ $enrollment->level->level_name ?? '—' }}
                    &middot; منذ: {{ optional($enrollment->enrolled_at)->format('M d, Y') ?? '—' }}
                </p>
            </div>
            <div style="display:flex;gap:.5rem;align-items:center;">
                <form method="POST" action="{{ route('courses.enrollments.update', $enrollment) }}" style="display:flex;gap:.5rem;align-items:center;">
                    @csrf @method('PUT')
                    <select name="status" style="font-size:.8125rem;border:1px solid #e2e8f0;border-radius:.375rem;padding:.375rem .5rem;color:#374151;">
                        @foreach(['Active', 'Completed', 'Dropped'] as $s)
                        <option value="{{ $s }}" @selected($enrollment->status === $s)>{{ ['Active'=>'نشط','Completed'=>'مكتمل','Dropped'=>'منسحب'][$s] ?? $s }}</option>
                        @endforeach
                    </select>
                    @if($course->levels->count())
                    <select name="level_id" style="font-size:.8125rem;border:1px solid #e2e8f0;border-radius:.375rem;padding:.375rem .5rem;color:#374151;">
                        <option value="">بدون طور</option>
                        @foreach($course->levels as $lvl)
                        <option value="{{ $lvl->level_id }}" @selected($enrollment->level_id === $lvl->level_id)>{{ $lvl->level_name }}</option>
                        @endforeach
                    </select>
                    @endif
                    <x-core-package::btn type="submit" color="secondary" size="sm">حفظ</x-core-package::btn>
                </form>
                <form method="POST" action="{{ route('courses.enrollments.destroy', $enrollment) }}"
                      onsubmit="return confirm('إزالة هذا التسجيل؟')">
                    @csrf @method('DELETE')
                    <x-core-package::btn type="submit" color="danger" size="sm">إزالة</x-core-package::btn>
                </form>
            </div>
        </div>

        @if($course->category === 'quran')
        <div style="margin-top:.75rem;background:#f8fafc;border-radius:.5rem;padding:.75rem 1rem;">
            <p style="font-size:.75rem;font-weight:600;color:#475569;margin:0 0 .5rem;">تقدم القرآن الكريم</p>
            @forelse($enrollment->quranProgress as $row)
            <p style="font-size:.8125rem;color:#334155;margin:.25rem 0;">
                <strong>{{ $row->surah }}</strong>
                @if($row->from_ayah) ({{ $row->from_ayah }}@if($row->to_ayah)–{{ $row->to_ayah }}@endif) @endif
                — {{ ['Hifz'=>'حفظ','Muraja3a'=>'مراجعة','Tajweed'=>'تجويد'][$row->activity] ?? $row->activity }}
                @if($row->evaluation) — {{ $row->evaluation }} @endif
                <span style="color:#94a3b8;">{{ optional($row->recorded_at)->format('M d, Y') }}</span>
                <form method="POST" action="{{ route('courses.progress.destroy', [$enrollment, $row]) }}"
                      onsubmit="return confirm('حذف هذا المدخل؟')" style="display:inline;margin-left:.5rem;">
                    @csrf @method('DELETE')
                    <button type="submit" style="font-size:.7rem;color:#ef4444;background:none;border:none;cursor:pointer;padding:0;">حذف</button>
                </form>
            </p>
            @empty
            <p style="font-size:.75rem;color:#94a3b8;margin:0;">لا يوجد تقدم مسجل بعد.</p>
            @endforelse
            <form method="POST" action="{{ route('courses.progress.store', $enrollment) }}"
                  style="display:grid;grid-template-columns:1fr 90px 90px 130px 120px auto;gap:.5rem;margin-top:.75rem;align-items:end;">
                @csrf
                <x-core-package::form.input name="surah" label="السورة" placeholder="مثال: البقرة" required />
                <x-core-package::form.input name="from_ayah" label="من" type="number" min="1" />
                <x-core-package::form.input name="to_ayah" label="إلى" type="number" min="1" />
                <x-core-package::form.select name="activity" label="النشاط">
                    <option value="Hifz">حفظ</option>
                    <option value="Muraja3a">مراجعة</option>
                    <option value="Tajweed">تجويد</option>
                </x-core-package::form.select>
                <x-core-package::form.input name="evaluation" label="التقييم" placeholder="مثال: ممتاز" />
                <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary" size="sm">تسجيل</x-core-package::btn></div>
            </form>
        </div>
        @endif
    </div>
    @empty
    <p style="padding:1.5rem;text-align:center;color:#94a3b8;font-size:.875rem;margin:0;">لا يوجد تسجيلات بعد.</p>
    @endforelse
    <form method="POST" action="{{ route('courses.enrollments.store', $course) }}"
          style="display:grid;grid-template-columns:1fr auto;gap:.75rem;padding:1rem 1.25rem;border-top:1px solid #f1f5f9;align-items:end;">
        @csrf
        <x-core-package::form.select name="student_id" label="تسجيل تلميذ" required>
            <option value="">اختر تلميذًا…</option>
            @foreach($students as $student)
            <option value="{{ $student->student_id }}">
                {{ $student->first_name }} {{ $student->last_name }} ({{ $student->admission_number }})
            </option>
            @endforeach
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary" size="sm">تسجيل</x-core-package::btn></div>
    </form>
</x-core-package::card>

@endsection
