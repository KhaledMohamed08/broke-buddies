<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="pt-12 pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="text-lg font-semibold">
                        {{ __('Create Shop') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('shops.store') }}" method="POST" id="shop-form">
                        @csrf

                        <div class="mb-4">
                            <label for="shop_category" class="block text-sm font-medium text-gray-700">{{ __('Shop Category') }}</label>
                            <select id="shop_category" name="shop_category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="" disabled selected>{{ __('Select a category') }}</option>
                                @foreach ($shopCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex mb-4">
                            <div class="flex-1 mr-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="{{ __('Enter shop name') }}" required>
                            </div>

                            <div class="flex-1 ml-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('Phone') }}</label>
                                <input type="text" id="phone" name="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="{{ __('Enter phone number') }}" required>
                            </div>
                        </div>

                        <div class="text-lg font-semibold pt-6 mb-2">{{ __('Shop Menu') }}</div>

                        <div x-data="{ categories: [] }">
                            <template x-for="(category, categoryIndex) in categories" :key="categoryIndex">
                                <div class="mt-6">
                                    <div class="bg-gray-50 p-4 rounded-lg shadow">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-800" x-text="category.name"></span>
                                            <x-danger-button type="button" @click="categories.splice(categoryIndex, 1)">
                                                {{ __('Remove This Category') }}
                                            </x-danger-button>
                                        </div>
                                        <div class="mt-4">
                                            <template x-for="(item, itemIndex) in category.items" :key="itemIndex">
                                                <div class="mt-4">
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Item Name</label>
                                                            <input type="text" x-model="item.name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter item name" required>

                                                            <div class="mt-4">
                                                                <template x-for="(sizeItem, sizeIndex) in item.sizes" :key="sizeIndex">
                                                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-4">
                                                                        <div>
                                                                            <label class="block text-sm font-medium text-gray-700">Size</label>
                                                                            <select x-model="sizeItem.size" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                                                <option value="" disabled selected>{{ __('Select Size') }}</option>
                                                                                <option value="S">S</option>
                                                                                <option value="M">M</option>
                                                                                <option value="L">L</option>
                                                                                <option value="No Size">{{ __('No Size') }}</option>
                                                                            </select>
                                                                        </div>

                                                                        <div>
                                                                            <label class="block text-sm font-medium text-gray-700">Price</label>
                                                                            <input type="number" min="1" x-model="sizeItem.price" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter price" required>
                                                                        </div>

                                                                        <div class="flex items-end">
                                                                            <x-danger-button class="m-1 p-1" type="button" @click="item.sizes.splice(sizeIndex, 1)">
                                                                                {{ __('-') }}
                                                                            </x-danger-button>
                                                                        </div>
                                                                    </div>
                                                                </template>

                                                                <div class="flex items-center justify-start mt-4">
                                                                    <x-primary-button type="button" @click="item.sizes.push({ size: '', price: '' })">
                                                                        {{ __('Add Size/Price') }}
                                                                    </x-primary-button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700">Description</label>
                                                            <textarea x-model="item.description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Enter item description" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center justify-end mt-4">
                                                        <x-danger-button class="m-1" type="button" @click="category.items.splice(itemIndex, 1)">
                                                            {{ __('Remove Item') }}
                                                        </x-danger-button>
                                                    </div>
                                                </div>
                                            </template>

                                            <div class="flex items-center justify-end mt-4">
                                                <x-primary-button class="m-1" type="button" @click="category.items.push({ name: '', sizes: [{ size: '', price: '' }], description: '' })">
                                                    {{ __('Add New Item') }}
                                                </x-primary-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div class="mt-4">
                                <x-primary-button type="button" @click="$dispatch('open-modal', 'add-category-modal')">
                                    {{ __('Add New Category') }}
                                </x-primary-button>
                            </div>

                            <x-modal name="add-category-modal" focusable>
                                <div class="p-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ __('Category Name') }}</label>
                                    <input type="text" id="new-category-name" x-model="newCategoryName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                    <div class="flex justify-end space-x-3 mt-6">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-primary-button type="button" @click="categories.push({ name: newCategoryName, items: [{ name: '', sizes: [{ size: '', price: '' }], description: '' }] }); newCategoryName = ''; $dispatch('close')">
                                            {{ __('Apply') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </x-modal>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <x-primary-button class="ml-3">
                                {{ __('Create Shop') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
