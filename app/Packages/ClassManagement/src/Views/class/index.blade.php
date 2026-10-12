@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">الأقسام</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">الأقسام</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تسيير أقسام المدرسة وإسنادها إلى السنوات الدراسية</p>
    </div>
    <x-core-package::btn :href="route('classes.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إضافة قسم
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('classes.index') }}"
          style="display:grid;grid-template-columns:1fr 200px 180px 180px 140px auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث" placeholder="اسم القسم أو رمزه"
            value="{{ request('search') }}" />
        <x-core-package::form.select name="level" label="الطور">
            <option value="" @selected(!request('level'))>كل الأطوار</option>
            @foreach($levels as $code => $label)
            <option value="{{ $code }}" @selected(request('level') === $code)>{{ $label }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="stream" label="الشعبة">
            <option value="" @selected(!request('stream'))>كل الشعب</option>
            @foreach($streams as $code => $label)
            <option value="{{ $code }}" @selected(request('stream') === $code)>{{ $label }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="academic_year_id" label="السنة الدراسية">
            <option value="" @selected(!request('academic_year_id'))>كل السنوات</option>
            @foreach($academicYears as $year)
            <option value="{{ $year->academic_year_id }}" @selected((string)request('academic_year_id') === (string)$year->academic_year_id)>
                {{ $year->year_range }}
            </option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="status" label="الحالة">
            <option value="" @selected(!request('status'))>الكل</option>
            <option value="active" @selected(request('status') === 'active')>نشط</option>
            <option value="inactive" @selected(request('status') === 'inactive')>غير نشط</option>
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('classes.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">القسم</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الطور</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الشعبة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">السنة الدراسية</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الأفواج</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;">
                    <div style="display:flex;align-items:center;gap:.75rem;">
                        <div style="width:2.25rem;height:2.25rem;background:linear-gradient(135deg,#0ea5e9,#38bdf8);border-radius:.5rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg style="width:1rem;height:1rem;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div>
                            <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $item->class_name }}</p>
                            @if($item->class_code)
                            <p style="font-size:.7rem;color:#94a3b8;margin:.125rem 0 0;">الرمز: {{ $item->class_code }}</p>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $levels[$item->level] ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $streams[$item->stream] ?? '—' }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->academicYear->year_range ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <span style="font-size:.875rem;font-weight:600;color:#1e293b;">{{ $item->sections->count() }}</span>
                    <span style="font-size:.75rem;color:#94a3b8;"> الأفواج</span>
                </td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge :color="$item->is_active ? 'green' : 'gray'">
                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                    </x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('classes.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('classes.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('classes.destroy', $item) }}"
                              onsubmit="return confirm('حذف {{ $item->class_name }}؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                    <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">
                    لا توجد أقسام.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
