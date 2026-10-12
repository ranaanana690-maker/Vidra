@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('financialReport.index') }}" style="color:#64748b;text-decoration:none;">التقارير المالية</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">Report #{{ $financialReport->report_id }}</span>
</nav>
@endsection

@section('content')

<x-core-package::alert type="info">
    التقارير المالية لقطات للقراءة فقط. للحصول على أرقام محدثة، أنشئ تقريرا جديدا لنفس الفترة.
</x-core-package::alert>

<div style="margin-top:1rem;">
    <x-core-package::btn :href="route('financialReport.show', $financialReport)" color="primary">عرض التقرير</x-core-package::btn>
    <x-core-package::btn :href="route('financialReport.index')" color="secondary" style="margin-left:.75rem;">رجوع للقائمة</x-core-package::btn>
</div>

@endsection
