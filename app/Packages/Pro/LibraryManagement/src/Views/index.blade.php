<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl">
        <h1 class="text-3xl font-bold mb-6">{{ $title }}</h1>
        <p class="text-gray-600 mb-8">{{ $message }}</p>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">العناصر</h2>

            @if(auth()->user()->can('create_library-management_item'))
                <form method="POST" action="{{ route('library-management.store') }}" class="mb-6">
                    @csrf
                    <div class="flex gap-2">
                        <input type="text" name="name" placeholder="اسم العنصر"
                               class="flex-1 px-3 py-2 border rounded" required>
                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            إضافة عنصر
                        </button>
                    </div>
                </form>
            @endif

            <p class="text-gray-500">لا يوجد عناصر بعد.</p>
        </div>
    </div>
</div>