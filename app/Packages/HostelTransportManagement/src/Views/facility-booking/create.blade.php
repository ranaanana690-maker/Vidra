@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('facility-bookings.index') }}" style="color:#64748b;text-decoration:none;">حجوزات المرافق</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">حجز جديد</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::facility-booking._form', [
    'title'  => 'حجز مرفق جديد',
    'action' => route('facility-bookings.store'),
    'method' => 'POST',
])
@endsection
