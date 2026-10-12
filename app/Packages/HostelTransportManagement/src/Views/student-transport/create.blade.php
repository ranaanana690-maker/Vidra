@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('student-transport.index') }}" style="color:#64748b;text-decoration:none;">إسناد النقل</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">إسناد تلميذ</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::student-transport._form', [
    'title'  => 'إسناد النقل لتلميذ',
    'action' => route('student-transport.store'),
    'method' => 'POST',
])
@endsection
