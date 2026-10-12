@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('hostels.index') }}" style="color:#64748b;text-decoration:none;">المراقد</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل المرقد</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::hostel._form', [
    'title'  => 'Edit Hostel: '.$hostel->hostel_name,
    'action' => route('hostels.update', $hostel),
    'method' => 'PUT',
])
@endsection
