<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div x-data="shoppingCart()" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="text-lg font-semibold">
                        {{ __($order->shop->name) }}
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex">
                        <!-- Shop Items Section -->
                        <div class="w-3/4 pr-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-semibold text-lg">Shop Items</h3>
                                <div class="w-1/4">
                                    <input type="text" placeholder="Search items..."
                                        class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring focus:ring-blue-500" />
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto p-4">
                                @foreach ($order->shop->shopCategories as $category)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-lg mb-2">{{ $category->name }}</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach ($category->items as $item)
                                                <div class="bg-gray-100 p-4 rounded-lg shadow transition-transform transform hover:scale-105">
                                                    <div class="font-bold text-sm mb-2">{{ $item->name }}</div>
                                                    <div class="mb-4">
                                                        <select x-model="selectedSizes[{{ $item->id }}]"
                                                                class="w-full border border-gray-300 rounded-md p-2"
                                                                @change="updatePrice({{ $item->id }})">
                                                            <option value="">Select Size</option>
                                                            @foreach ($item->detalis as $details)
                                                                <option value="{{ $details->price }}"
                                                                        data-name="{{ $item->name }}"
                                                                        data-size="{{ $details->size ?? 'One Size' }}">
                                                                    {{ $details->size ?? 'One Size' }} /
                                                                    ${{ $details->price }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mt-2 text-gray-800 font-semibold price-display">
                                                        Price: $<span x-text="prices[{{ $item->id }}]">0.00</span>
                                                    </div>
                                                    <div class="mt-4">
                                                        <x-primary-button type="button"
                                                                          @click="addToCart({{ $item->id }}, $event)">
                                                            {{ __('Add to Cart') }}
                                                        </x-primary-button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Cart Items Section -->
                        <div class="w-1/4 pl-4">
                            <h3 class="font-semibold text-lg mb-4">Cart Items</h3>
                            <div class="max-h-96 overflow-y-auto min-h-[400px]"> <!-- Set min height here -->
                                <template x-for="(cartItem, index) in cart" :key="index">
                                    <div class="bg-gray-100 p-4 rounded-lg shadow mb-4">
                                        <div class="flex justify-between items-center">
                                            <span class="font-bold" x-text="cartItem.name"></span>
                                            <div class="flex items-center">
                                                <input type="number" x-model.number="cartItem.quantity" min="1"
                                                       class="border border-gray-300 rounded-md w-16 text-center mr-2"
                                                       @input="updateTotalPrice()" />
                                                <span class="font-semibold"
                                                      x-text="`$${(cartItem.price * cartItem.quantity).toFixed(2)}`"></span>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        
                            <div class="mt-4 flex items-center">
                                <span class="font-semibold text-lg mr-2">Total:</span>
                                <span class="font-bold text-lg" x-text="`$${totalPrice.toFixed(2)}`"></span>
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
    </div>

    <script>
        function shoppingCart() {
            return {
                cart: [],
                selectedSizes: {},
                prices: {},
                totalPrice: 0,

                updatePrice(itemId) {
                    const selectedOption = document.querySelector(`select[x-model="selectedSizes[${itemId}]"] option:checked`);
                    const price = selectedOption ? parseFloat(selectedOption.value) : 0;
                    this.prices[itemId] = price.toFixed(2);
                },

                addToCart(itemId, event) {
                    const selectedSize = this.selectedSizes[itemId];
                    const selectedOption = event.target.closest('.bg-gray-100').querySelector(`select[x-model="selectedSizes[${itemId}]"] option:checked`);
                    const itemName = selectedOption ? selectedOption.dataset.name : '';
                    const sizeName = selectedOption ? selectedOption.dataset.size : '';
                    const price = selectedOption ? parseFloat(selectedOption.value) : 0;

                    // Validation: Check if size is selected
                    if (!selectedSize) {
                        alert('Please select a size before adding to the cart.');
                        return;
                    }

                    // Create a unique identifier for the cart item using both name and size
                    const uniqueItemName = `${itemName} [${sizeName}] ${price}`;

                    // Check if the item is already in the cart
                    const existingItem = this.cart.find(item => item.name === uniqueItemName);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.cart.push({
                            name: uniqueItemName,
                            price: price,
                            quantity: 1
                        });
                    }

                    // Update total price
                    this.updateTotalPrice();
                },

                updateTotalPrice() {
                    this.totalPrice = this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                }
            };
        }
    </script>
</x-app-layout>
