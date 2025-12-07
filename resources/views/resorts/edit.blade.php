<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            リゾート編集
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-4 sm:p-6">
                <form method="POST" action="{{ route('resorts.update', $resort) }}">
                    @method('PUT')
                    @include('resorts._form', ['resort' => $resort])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
