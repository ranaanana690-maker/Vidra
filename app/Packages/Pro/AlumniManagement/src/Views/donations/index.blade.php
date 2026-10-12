@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">الخريجون / التبرعات</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">التبرعات</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">تتبع مساهمات الخريجين</p>
    </div>
    <x-core-package::btn :href="route('alumni.donations.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        تسجيل تبرع
    </x-core-package::btn>
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1rem;">{{ session('success') }}</x-core-package::alert>
@endif

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    @foreach([
        ['label'=>'مجموع التبرعات','value'=>$stats['total_donations'],'color'=>'#4f46e5','prefix'=>''],
        ['label'=>'المبلغ المؤكد','value'=>number_format($stats['confirmed_total'],2),'color'=>'#059669','prefix'=>'₹'],
        ['label'=>'المعلقة','value'=>$stats['pending_count'],'color'=>'#d97706','prefix'=>''],
        ['label'=>'صندوق المنح','value'=>number_format($stats['scholarship_total'],2),'color'=>'#0891b2','prefix'=>'₹'],
    ] as $stat)
    <div style="background:#fff;border-radius:.625rem;border:1px solid #e2e8f0;padding:1rem 1.25rem;">
        <div style="font-size:.75rem;color:#64748b;margin-bottom:.25rem;">{{ $stat['label'] }}</div>
        <div style="font-size:1.25rem;font-weight:700;color:{{ $stat['color'] }};">{{ $stat['prefix'] }}{{ $stat['value'] }}</div>
    </div>
    @endforeach
</div>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الخريج</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المبلغ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الغرض</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">التاريخ</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الوصل</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($donations as $donation)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;">
                    <div style="font-weight:600;color:#1e293b;">{{ $donation->alumni->full_name }}</div>
                    <div style="font-size:.75rem;color:#64748b;">دفعة {{ $donation->alumni->graduation_year }}</div>
                </td>
                <td style="padding:.75rem 1rem;font-weight:600;color:#059669;">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</td>
                <td style="padding:.75rem 1rem;"><x-core-package::badge color="indigo">{{ ['scholarship'=>'منحة','infrastructure'=>'بنية تحتية','general'=>'عام'][$donation->purpose] ?? ucfirst($donation->purpose) }}</x-core-package::badge></td>
                <td style="padding:.75rem 1rem;color:#64748b;">{{ $donation->donated_at->format('d M Y') }}</td>
                <td style="padding:.75rem 1rem;font-size:.75rem;color:#94a3b8;">{{ $donation->receipt_number ?? '—' }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ match($donation->status) { 'confirmed' => 'green', 'pending' => 'yellow', default => 'red' } }}">
                        {{ ['confirmed'=>'مؤكد','pending'=>'معلق','cancelled'=>'ملغى'][$donation->status] ?? ucfirst($donation->status) }}
                    </x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    @if($donation->status === 'pending')
                    <form method="POST" action="{{ route('alumni.donations.confirm', $donation) }}">
                        @csrf
                        <x-core-package::btn type="submit" color="primary" size="sm">تأكيد</x-core-package::btn>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد تبرعات مسجلة بعد.</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $donations->links() }}</div>

@endsection
