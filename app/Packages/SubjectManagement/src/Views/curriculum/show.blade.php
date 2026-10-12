@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('curriculums.index') }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">المنهاج</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">{{ $curriculum->subject->subject_name ?? 'Detail' }}</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">
            {{ $curriculum->subject->subject_name ?? '—' }} — {{ $curriculum->academicYear->year_range ?? '—' }}
        </h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تفاصيل المنهاج وخطط الدروس</p>
    </div>
    <div style="display:flex;gap:.5rem;flex-shrink:0;">
        <x-core-package::btn :href="route('curriculums.edit', $curriculum)" color="primary" size="sm">تعديل</x-core-package::btn>
        <x-core-package::btn :href="route('curriculums.index')" color="secondary" size="sm">رجوع</x-core-package::btn>
    </div>
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1.25rem;">{{ session('success') }}</x-core-package::alert>
@endif

<div style="display:grid;grid-template-columns:minmax(0,1fr) 22rem;gap:1.25rem;align-items:start;">
    <div>
        {{-- Lesson Plans --}}
        <x-core-package::card :noPadding="true">
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.25rem;border-bottom:1px solid #f1f5f9;">
                <p style="font-size:.9375rem;font-weight:600;color:#1e293b;margin:0;">خطط الدروس</p>
                <x-core-package::btn :href="route('lesson-plans.create').'?curriculum_id='.$curriculum->curriculum_id" color="primary" size="sm">+ إضافة خطة درس</x-core-package::btn>
            </div>
            @if($curriculum->lessonPlans->count())
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
                    <thead>
                        <tr style="background:#f8fafc;">
                            <th style="padding:.5rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الموضوع</th>
                            <th style="padding:.5rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التواريخ</th>
                            <th style="padding:.5rem 1rem;border-bottom:1px solid #e2e8f0;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($curriculum->lessonPlans as $plan)
                    <tr style="border-bottom:1px solid #f1f5f9;">
                        <td style="padding:.625rem 1.25rem;font-weight:600;color:#1e293b;">{{ $plan->topic_name }}</td>
                        <td style="padding:.625rem 1rem;color:#64748b;">
                            @if($plan->start_date)
                                {{ $plan->start_date->format('M d') }} – {{ optional($plan->end_date)->format('M d, Y') ?: '?' }}
                            @else —
                            @endif
                        </td>
                        <td style="padding:.625rem 1rem;">
                            <div style="display:flex;gap:.375rem;">
                                <x-core-package::btn :href="route('lesson-plans.show', $plan)" color="primary" size="sm">عرض</x-core-package::btn>
                                <form method="POST" action="{{ route('lesson-plans.destroy', $plan) }}"
                                      onsubmit="return confirm('حذف خطة الدرس؟')">
                                    @csrf @method('DELETE')
                                    <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p style="padding:1.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا توجد خطط دروس بعد.</p>
            @endif
        </x-core-package::card>
    </div>

    <div style="display:flex;flex-direction:column;gap:1.25rem;">
        <x-core-package::card title="معلومات المنهاج">
            <div style="display:flex;flex-direction:column;gap:.875rem;font-size:.875rem;">
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">المادة</p>
                    <p style="font-weight:500;color:#1e293b;margin:0;">{{ $curriculum->subject->subject_name ?? '—' }}</p>
                </div>
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">السنة الدراسية</p>
                    <p style="font-weight:500;color:#1e293b;margin:0;">{{ $curriculum->academicYear->year_range ?? '—' }}</p>
                </div>
                @if($curriculum->syllabus_document_path)
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">وثيقة المنهاج</p>
                    <p style="color:#4f46e5;margin:0;word-break:break-all;">{{ $curriculum->syllabus_document_path }}</p>
                </div>
                @endif
                @if($curriculum->description)
                <div>
                    <p style="font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;margin:0 0 .25rem;">الوصف</p>
                    <p style="color:#475569;margin:0;line-height:1.5;">{{ $curriculum->description }}</p>
                </div>
                @endif
            </div>
        </x-core-package::card>

        <x-core-package::card title="منطقة الخطر">
            <form method="POST" action="{{ route('curriculums.destroy', $curriculum) }}">
                @csrf @method('DELETE')
                <p style="font-size:.75rem;color:#64748b;margin:0 0 .875rem;">حذف المنهاج وجميع خطط دروسه.</p>
                <x-core-package::btn type="submit" color="danger"
                    onclick="return confirm('حذف هذا المنهاج؟ ستُحذف جميع خطط الدروس.')">
                    حذف المنهاج
                </x-core-package::btn>
            </form>
        </x-core-package::card>
    </div>
</div>
@endsection
