@extends('core-package::layouts.app')

@section('breadcrumb')
<nav style="font-size:.8125rem;color:#64748b;">
    <span style="color:#374151;font-weight:500;">المكتبة / الكتب</span>
</nav>
@endsection

@section('content')

<div style="display:flex;align-items:center;justify-content:space-between;gap:1rem;margin-bottom:1.5rem;">
    <div>
        <h1 style="font-size:1.375rem;font-weight:700;color:#1e293b;margin:0;">فهرس الكتب</h1>
        <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0;">إدارة جميع كتب المكتبة</p>
    </div>
    @can('create_library-management_item')
    <x-core-package::btn :href="route('library.books.create')" color="primary">
        <svg style="width:.875rem;height:.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        إضافة كتاب
    </x-core-package::btn>
    @endcan
</div>

@if(session('success'))
<x-core-package::alert type="success" style="margin-bottom:1rem;">{{ session('success') }}</x-core-package::alert>
@endif

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem;">
    @foreach([['label'=>'مجموع الكتب','value'=>$stats['total_books'],'color'=>'#4f46e5'],['label'=>'مجموع النسخ','value'=>$stats['total_copies'],'color'=>'#0891b2'],['label'=>'متوفر','value'=>$stats['available_copies'],'color'=>'#059669'],['label'=>'الأصناف','value'=>$stats['categories'],'color'=>'#d97706']] as $stat)
    <div style="background:#fff;border-radius:.625rem;border:1px solid #e2e8f0;padding:1rem 1.25rem;">
        <div style="font-size:.75rem;color:#64748b;margin-bottom:.25rem;">{{ $stat['label'] }}</div>
        <div style="font-size:1.5rem;font-weight:700;color:{{ $stat['color'] }};">{{ $stat['value'] }}</div>
    </div>
    @endforeach
</div>

{{-- Search --}}
<x-core-package::card style="margin-bottom:1.25rem;">
    <form method="GET" action="{{ route('library.books.search') }}" style="display:flex;gap:.75rem;align-items:flex-end;">
        <div style="flex:1;">
            <x-core-package::form.input name="query" label="بحث في الكتب" type="text"
                :value="request('query')" placeholder="العنوان أو المؤلف أو الرقم الدولي..." />
        </div>
        <div style="padding-top:1.375rem;">
            <x-core-package::btn type="submit" color="primary">بحث</x-core-package::btn>
        </div>
    </form>
</x-core-package::card>

<x-core-package::card :noPadding="true">
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;font-size:.8125rem;">
            <thead>
                <tr style="background:#f8fafc;">
                    <th style="padding:.625rem 1.25rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">#</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">العنوان / المؤلف</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الصنف</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">متوفر</th>
                    <th style="padding:.625rem 1rem;text-align:center;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">المجموع</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">الحالة</th>
                    <th style="padding:.625rem 1rem;text-align:left;font-size:.65rem;font-weight:600;color:#94a3b8;text-transform:uppercase;letter-spacing:.05em;border-bottom:1px solid #e2e8f0;">إجراءات</th>
                </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
            <tr style="border-bottom:1px solid #f1f5f9;">
                <td style="padding:.75rem 1.25rem;color:#94a3b8;font-size:.75rem;">{{ $book->id }}</td>
                <td style="padding:.75rem 1rem;">
                    <div style="font-weight:600;color:#1e293b;">{{ $book->title }}</div>
                    <div style="font-size:.75rem;color:#64748b;">{{ $book->author }} @if($book->isbn) · {{ $book->isbn }}@endif</div>
                </td>
                <td style="padding:.75rem 1rem;">
                    @if($book->category)
                    <x-core-package::badge color="indigo">{{ $book->category->name }}</x-core-package::badge>
                    @else
                    <span style="color:#94a3b8;">—</span>
                    @endif
                </td>
                <td style="padding:.75rem 1rem;text-align:center;">
                    <span style="font-weight:600;color:{{ $book->available_copies > 0 ? '#059669' : '#dc2626' }};">{{ $book->available_copies }}</span>
                </td>
                <td style="padding:.75rem 1rem;text-align:center;color:#64748b;">{{ $book->total_copies }}</td>
                <td style="padding:.75rem 1rem;">
                    <x-core-package::badge color="{{ $book->status === 'active' ? 'green' : 'red' }}">{{ $book->status }}</x-core-package::badge>
                </td>
                <td style="padding:.75rem 1rem;">
                    <div style="display:flex;gap:.5rem;">
                        @can('edit_library-management_item')
                        <x-core-package::btn :href="route('library.books.edit', $book)" color="secondary" size="sm">تعديل</x-core-package::btn>
                        @endcan
                        @can('delete_library-management_item')
                        <form method="POST" action="{{ route('library.books.destroy', $book) }}" onsubmit="return confirm('حذف هذا الكتاب؟')">
                            @csrf @method('DELETE')
                            <x-core-package::btn type="submit" color="danger" size="sm">حذف</x-core-package::btn>
                        </form>
                        @endcan
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="padding:2.5rem;text-align:center;color:#94a3b8;font-size:.875rem;">لا يوجد كتب. @can('create_library-management_item')<a href="{{ route('library.books.create') }}" style="color:#4f46e5;">أضف أول كتاب</a>@endcan</td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</x-core-package::card>

<div style="margin-top:1rem;">{{ $books->links() }}</div>

@endsection
