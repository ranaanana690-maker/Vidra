@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('class-subjects.index') }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">مواد الأقسام</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">إسناد مادة</span>
</nav>
@endsection

@section('content')
@include('subject-management::class-subject._form', [
    'classSubject' => null,
    'action'       => route('class-subjects.store'),
    'method'       => 'POST',
    'title'        => 'إسناد مادة إلى قسم',
    'classes'      => $classes,
    'subjects'     => $subjects,
])
@endsection
