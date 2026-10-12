@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">المكتبة / الإعارات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">إعارات الكتب</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إعارات الكتب النشطة والإرجاعات</p>
    </div>
    <div style="display:flex;gap:.75rem;">
        <x-core-package::btn :href="route('library.issues.overdue')" color="secondary">متأخر</x-core-package::btn>
        @can('create_library-management_item')
        <x-core-package::btn :href="route('library.issues.create')" color="primary">
            <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            إعارة كتاب
        </x-core-package::btn>
        @endcan
    </div>
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1rem;">{{ session('success') }}</x-core-package::alert>
@endif
@if(session('error'))
<x-core-package::alert type="error" style="margin-bottom:1rem;">{{ session('error') }}</x-core-package::alert>
@endif

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الكتاب</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">العضو</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ الإعارة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">تاريخ الاستحقاق</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($issues as $issue)
            @php
                $isOverdue = $issue->due_date && \Carbon\Carbon::parse($issue->due_date)->isPast() && $issue->status !== 'returned';
            @endphp
            <tr style="border-bottom:1px solid #f1f5f9;{{ $isOverdue ? 'background:#fff7ed;' : '' }}">
                <td style="padding:.75rem 1.25rem;">
                    <div style="font-weight:600;color:#1e293b;">{{ $issue->book->title ?? 'N/A' }}</div>
                    <div style="font-size:.75rem;color:#64748b;">{{ $issue->book->author ?? '' }}</div>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="font-weight:500;color:#1e293b;">{{ $issue->member->name ?? 'N/A' }}</div>
                    <div style="font-size:.75rem;color:#64748b;">{{ $issue->member->membership_number ?? '' }}</div>
                </td>
                <td style="padding:.75rem 1rem;color:#64748b;">
                    {{ $issue->issue_date ? \Carbon\Carbon::parse($issue->issue_date)->format('d M Y') : '—' }}
                </td>
                <td style="padding:.75rem 1rem;color:{{ $isOverdue ? '#dc2626' : '#64748b' }};font-weight:{{ $isOverdue ? '600' : 'normal' }};">
                    {{ $issue->due_date ? \Carbon\Carbon::parse($issue->due_date)->format('d M Y') : '—' }}
                    @if($isOverdue)<div style="font-size:.7rem;color:#dc2626;">متأخر</div>@endif
                </td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ $issue->status === 'returned' ? 'green' : ($isOverdue ? 'red' : 'yellow') }}">
                        {{ $issue->status }}
                    </x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    @if($issue->status !== 'returned')
                    @can('edit_library-management_item')
                    <form method="POST" action="{{ route('library.issues.return', $issue) }}" onsubmit="return confirm('تأكيد الإرجاع؟')">
                        @csrf
                        <x-core-package::btn type="submit" color="primary" size="sm">إرجاع</x-core-package::btn>
                    </form>
                    @endcan
                    @else
                    <span style="color:#94a3b8;font-size:.75rem;">مُرجع</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد إعارات نشطة.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

@endsection
