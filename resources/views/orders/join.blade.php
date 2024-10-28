<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="text-lg font-semibold">
                        {{ __('Shop Name') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex">
                    <div class="w-3/4 pr-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-semibold text-lg">Shop Items</h3>
                            
                            <div class="w-1/4">
                                <input 
                                    type="text" 
                                    placeholder="Search items..." 
                                    class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring focus:ring-blue-500"
                                />
                            </div>
                        </div>
                        

                        <div class="max-h-96 overflow-y-auto">
                            {{-- Category 1 --}}
                            <div class="mb-6">
                                <h4 class="font-semibold text-lg mb-2">Category 1</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 1</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$19.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 2</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$29.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 3</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$39.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 4</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$49.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                            {{-- Category 2 --}}
                            <div class="mb-6">
                                <h4 class="font-semibold text-lg mb-2">Category 2</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 5</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$59.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                    <div class="bg-gray-100 p-4 rounded-lg shadow">
                                        <div class="font-bold text-sm">Item 6</div>
                                        <div class="mt-2 font-semibold text-lg text-gray-800">$69.99</div>
                                        <div class="mt-4">
                                            <x-primary-button>
                                                <a href="#" class="text-white">{{ __('Add to Cart') }}</a>
                                            </x-primary-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                                       
                    
                    <div class="w-1/4 pl-4">
                        <h3 class="font-semibold text-lg mb-4">Cart Items</h3>
                        <div class="max-h-96 overflow-y-auto">
                            <div class="bg-gray-100 p-4 rounded-lg shadow mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold">Item 1</span>
                                    <div class="flex items-center">
                                        <input 
                                            type="number" 
                                            value="1" 
                                            min="1" 
                                            class="border border-gray-300 rounded-md w-16 text-center mr-2"
                                        />
                                        <span class="font-semibold">$19.99</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-100 p-4 rounded-lg shadow mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold">Item 2</span>
                                    <div class="flex items-center">
                                        <input 
                                            type="number" 
                                            value="1" 
                                            min="1" 
                                            class="border border-gray-300 rounded-md w-16 text-center mr-2"
                                        />
                                        <span class="font-semibold">$29.99</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="mt-4 flex items-center">
                            <span class="font-semibold text-lg mr-2">Total:</span>
                            <span id="totalPrice" class="font-bold text-lg">$49.98</span>
                            <div class="ml-auto">
                                <x-primary-button>
                                    {{ __('Create Order') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
