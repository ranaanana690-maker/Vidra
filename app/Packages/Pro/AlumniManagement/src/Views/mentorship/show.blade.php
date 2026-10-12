@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('alumni.mentorship.index') }}" style="color:#64748b;text-decoration:none;">المرافقة</a>
    <span style="margin:0 .375rem;">›</span>
    <span style="color:#374151;font-weight:500;">مرافقة رقم {{ $mentorship->id }}</span>
</nav>
@endsection

@section('content')

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1rem;">{{ session('success') }}</x-core-package::alert>
@endif

<div style="max-width:640px;margin:0 auto;">

<x-core-package::card>
    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1.25rem;">
        <div>
            <h1 style="font-size:1.25rem;font-weight:700;color:#1e293b;margin:0 0 .375rem;">مرافقة توجيهية</h1>
            <x-core-package::badge color="{{ match($mentorship->status) { 'active' => 'green', 'completed' => 'blue', default => 'red' } }}">
                {{ ['active'=>'نشطة','completed'=>'مكتملة','cancelled'=>'ملغاة'][$mentorship->status] ?? ucfirst($mentorship->status) }}
            </x-core-package::badge>
        </div>
        @can('manage_alumni_mentorship')
        @if($mentorship->status === 'active')
        <form method="POST" action="{{ route('alumni.mentorship.complete', $mentorship) }}">
            @csrf
            <x-core-package::btn type="submit" color="primary">إتمام</x-core-package::btn>
        </form>
        @endif
        @endcan
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
        <div>
            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:.25rem;">المرافق</div>
            <div style="font-weight:600;color:#1e293b;">{{ $mentorship->mentor->full_name }}</div>
            <div style="font-size:.8125rem;color:#64748b;">دفعة {{ $mentorship->mentor->graduation_year }}</div>
            <div style="font-size:.8125rem;color:#64748b;">{{ $mentorship->mentor->email }}</div>
        </div>
        <div>
            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:.25rem;">المُرافَق</div>
            <div style="font-weight:600;color:#1e293b;">{{ $mentorship->mentee_name }}</div>
            @if($mentorship->mentee_student_id)
            <div style="font-size:.8125rem;color:#64748b;">رقم التلميذ: {{ $mentorship->mentee_student_id }}</div>
            @endif
        </div>
        <div>
            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:.25rem;">المجال</div>
            <div style="font-weight:600;color:#1e293b;">{{ $mentorship->area_of_mentorship }}</div>
        </div>
        <div>
            <div style="font-size:.75rem;color:#94a3b8;margin-bottom:.25rem;">المدة</div>
            <div style="font-weight:600;color:#1e293b;">
                {{ $mentorship->start_date->format('d M Y') }} →
                {{ $mentorship->end_date ? $mentorship->end_date->format('d M Y') : 'مستمرة' }}
            </div>
        </div>
    </div>
</x-core-package::card>

</div>
@endsection
