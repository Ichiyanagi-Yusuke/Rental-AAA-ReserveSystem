<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ギア新規登録
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('gear-items.store') }}" method="POST">
                    @php($gearItem = null)
                    @include('gear_items._form', ['gearItem' => $gearItem])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
