<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add Grocery Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('grocery.store') }}">
                        @csrf

                        <!-- Item Name -->
                        <div class="mb-4">
                            <x-input-label for="item_name" :value="__('Item Name')" />
                            <x-text-input id="item_name" class="block mt-1 w-full" type="text" name="item_name" required autofocus />
                            <x-input-error :messages="$errors->get('item_name')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <x-text-input id="category" class="block mt-1 w-full" type="text" name="category" />
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Estimated Price -->
                        <div class="mb-4">
                            <x-input-label for="estimated_price" :value="__('Estimated Price')" />
                            <x-text-input id="estimated_price" class="block mt-1 w-full" type="number" step="0.01" name="estimated_price" />
                            <x-input-error :messages="$errors->get('estimated_price')" class="mt-2" />
                        </div>

                        <!-- Purchased -->
                        <div class="mb-4">
                            <x-input-label for="purchased" :value="__('Purchased')" />
                            <select id="purchased" name="purchased" class="block mt-1 w-full">
                                <option value="0">{{ __('No') }}</option>
                                <option value="1">{{ __('Yes') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('purchased')" class="mt-2" />
                        </div>

                        <!-- Submit -->
                        <div class="flex items-center justify-end">
                            <x-primary-button class="ml-4">
                                {{ __('Add Grocery Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
