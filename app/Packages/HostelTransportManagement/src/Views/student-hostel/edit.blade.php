@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('student-hostels.index') }}" style="color:#64748b;text-decoration:none;">إسكان التلاميذ</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل الإسناد</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::student-hostel._form', [
    'title'  => 'تعديل إسكان المرقد',
    'action' => route('student-hostels.update', $studentHostel),
    'method' => 'PUT',
])
@endsection
