@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('transportation.index') }}" style="color:#64748b;text-decoration:none;">النقل</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إضافة نقل</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::transportation._form', [
    'title'  => 'إضافة خدمة نقل جديدة',
    'action' => route('transportation.store'),
    'method' => 'POST',
])
@endsection
