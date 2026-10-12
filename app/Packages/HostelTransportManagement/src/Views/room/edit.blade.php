@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <a href="{{ route('hostel-rooms.index') }}" style="color:#64748b;text-decoration:none;">غرف المراقد</a>
    <span style="margin:0 .375rem;">/</span>
    <span style="color:#374151;font-weight:500;">تعديل القاعة</span>
</nav>
@endsection

@section('content')
@include('hostel-transport::room._form', [
    'title'  => 'Edit Room: '.$room->room_number,
    'action' => route('hostel-rooms.update', $room),
    'method' => 'PUT',
])
@endsection
