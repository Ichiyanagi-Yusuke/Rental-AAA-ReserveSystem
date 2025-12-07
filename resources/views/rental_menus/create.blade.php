{{-- resources/views/rental_menus/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニュー新規登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('rental-menus.store') }}" method="POST">
                    @php($rentalMenu = null)
                    @include('rental_menus._form', ['rentalMenu' => $rentalMenu])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
