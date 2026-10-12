@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('studentLeaveRequest.index') }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">طلبات رخص التلاميذ</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <a href="{{ route('studentLeaveRequest.show', $studentLeaveRequest) }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">طلب #{{ $studentLeaveRequest->leave_request_id }}</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل</span>
</nav>
@endsection

@section('content')
@include('attendance-management::student-leave-request._form', [
    'record' => $studentLeaveRequest,
    'action' => route('studentLeaveRequest.update', $studentLeaveRequest),
    'method' => 'PUT',
    'title'  => 'تعديل طلب الرخصة',
])
@endsection
