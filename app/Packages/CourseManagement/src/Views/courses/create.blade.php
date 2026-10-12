@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('courses.index') }}" style="color:#94a3b8;text-decoration:none;"
       onmouseover="this.style.color='#374151'" onmouseout="this.style.color='#94a3b8'">Courses</a>
    <span style="margin:0 .375rem;color:#cbd5e1;">/</span>
    <span style="color:#374151;font-weight:500;">New Course</span>
</nav>
@endsection

@section('content')
@include('course-management::courses._form', [
    'course'     => null,
    'action'     => route('courses.store'),
    'method'     => 'POST',
    'title'      => 'Create Course',
    'categories' => $categories,
])
@endsection
