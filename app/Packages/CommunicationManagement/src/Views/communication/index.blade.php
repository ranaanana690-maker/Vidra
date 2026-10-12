@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">إعدادات الإشعارات</h1>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">المعرف</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">إجراءات</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{ $item->setting_id ?? \$item->id ?? 'N/A' }</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{ route('communication.show', \$item) }" class="text-indigo-600">عرض</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" class="px-6 py-4 text-center text-gray-500">لا توجد سجلات</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
