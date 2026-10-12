@extends('core-package::layouts.app')

@section('title', 'إعدادات الويب هوك')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">

    <x-core-package::page-header title="إعدادات الويب هوك" subtitle="اضبط رابطا خارجيا لاستقبال أحداث المدرسة الآنية.">
        <x-slot:actions>
            <x-core-package::btn id="save-btn" color="primary">حفظ الإعدادات</x-core-package::btn>
        </x-slot:actions>
    </x-core-package::page-header>

    @if(session('success'))
        <x-core-package::alert type="success">{{ session('success') }}</x-core-package::alert>
    @endif

    <div id="flash-msg" class="hidden mb-4 p-3 rounded-lg text-sm font-medium"></div>

    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6 space-y-6">

        {{-- Active toggle --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-gray-800">@lang('webhook::app.settings.active')</p>
                <p class="text-xs text-gray-500 mt-0.5">أوقف أو استأنف كل إرسالات الويب هوك.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="webhook_active" class="sr-only peer"
                    {{ ($settings['webhook_active'] ?? 0) ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-indigo-500 rounded-full peer
                            peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                            after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all
                            peer-checked:after:translate-x-full"></div>
            </label>
        </div>

        <hr class="border-gray-100">

        {{-- رابط الويب هوك --}}
        <x-core-package::form.section label="رابط الويب هوك" hint="كل الأحداث سترسل JSON إلى هذا الرابط.">
            <x-core-package::form.input
                id="webhook_url"
                type="url"
                placeholder="https://your-endpoint.example.com/hook"
                :value="$settings['webhook_url'] ?? ''"
            />
        </x-core-package::form.section>

        {{-- معلومات الأحداث --}}
        <div class="bg-indigo-50 rounded-xl p-4">
            <p class="text-xs font-semibold text-indigo-700 mb-2">الأحداث المرسلة</p>
            <ul class="text-xs text-indigo-600 space-y-1 list-disc list-inside">
                <li><code>student.created</code> / <code>student.updated</code></li>
                <li><code>staff.created</code> / <code>staff.updated</code></li>
                <li><code>attendance.marked</code></li>
                <li><code>fee.paid</code></li>
                <li><code>exam.result</code></li>
            </ul>
        </div>

    </div>

    <div class="mt-4 text-right">
        <a href="{{ route('webhook.logs.index') }}" class="text-sm text-indigo-600 hover:underline">
            عرض سجلات الويب هوك →
        </a>
    </div>

</div>

<script>
document.getElementById('save-btn').addEventListener('click', function () {
    const url    = document.getElementById('webhook_url').value;
    const active = document.getElementById('webhook_active').checked ? 1 : 0;
    const flash  = document.getElementById('flash-msg');

    fetch('{{ route("webhook.settings.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ webhook_url: url, webhook_active: active }),
    })
    .then(r => r.json())
    .then(data => {
        flash.textContent = data.message;
        flash.className = 'mb-4 p-3 rounded-lg text-sm font-medium ' +
            (data.success ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200');
        flash.classList.remove('hidden');
        setTimeout(() => flash.classList.add('hidden'), 4000);
    });
});
</script>
@endsection
