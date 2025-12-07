<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            レンタルメニューカテゴリ編集：{{ $rentalMenuCategory->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('rental-menu-categories.update', $rentalMenuCategory) }}" method="POST">
                    @method('PUT')
                    @include('rental_menu_categories._form', ['rentalMenuCategory' => $rentalMenuCategory])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
