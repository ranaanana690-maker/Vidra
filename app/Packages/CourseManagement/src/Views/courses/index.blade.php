@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">الدورات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">الدورات</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إدارة الدورات الداعمة: القرآن الكريم واللغات والسوروبان وغيرها</p>
    </div>
    <x-core-package::btn :href="route('courses.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إضافة دورة
    </x-core-package::btn>
</div>

<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('courses.index') }}"
          style="display:grid;grid-template-columns:1fr 200px 160px auto auto;gap:.75rem;align-items:end;">
        <x-core-package::form.input name="search" label="بحث" placeholder="اسم الدورة أو الرمز"
            value="{{ request('search') }}" />
        <x-core-package::form.select name="category" label="الصنف">
            <option value="" @selected(!request('category'))>كل الأصناف</option>
            @foreach($categories as $code => $label)
            <option value="{{ $code }}" @selected(request('category') === $code)>{{ $label }}</option>
            @endforeach
        </x-core-package::form.select>
        <x-core-package::form.select name="status" label="الحالة">
            <option value="" @selected(!request('status'))>الكل</option>
            <option value="active" @selected(request('status') === 'active')>نشط</option>
            <option value="inactive" @selected(request('status') === 'inactive')>غير نشط</option>
        </x-core-package::form.select>
        <div style="padding-top:1.375rem;"><x-core-package::btn type="submit" color="primary">تصفية</x-core-package::btn></div>
        <div style="padding-top:1.375rem;"><x-core-package::btn :href="route('courses.index')" color="secondary">إعادة تعيين</x-core-package::btn></div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الدورة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الصنف</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">السعر</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الأطوار / التلاميذ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;">
                    <p style="font-size:.875rem;font-weight:600;color:#1e293b;margin:0;">{{ $item->name }}</p>
                    @if($item->code)
                    <p style="font-size:.7rem;color:#94a3b8;margin:.125rem 0 0;">الرمز: {{ $item->code }}</p>
                    @endif
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $categories[$item->category] ?? $item->category }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ number_format($item->price, 2) }}</td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $item->levels_count }} / {{ $item->enrollments_count }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge :color="$item->is_active ? 'green' : 'gray'">
                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                    </x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;align-items:center;">
                        <x-core-package::btn :href="route('courses.show', $item)" color="primary" size="sm">عرض</x-core-package::btn>
                        <x-core-package::btn :href="route('courses.edit', $item)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        <form method="POST" action="{{ route('courses.destroy', $item) }}"
                              onsubmit="return confirm('حذف {{ $item->name }}؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">
                    لا يوجد دورات.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $items->links() }}</div>

@endsection
