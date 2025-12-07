{{-- resources/views/rental_menus/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニュー編集：{{ $rentalMenu->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('rental-menus.update', $rentalMenu) }}" method="POST">
                    @method('PUT')
                    @include('rental_menus._form', ['rentalMenu' => $rentalMenu])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
