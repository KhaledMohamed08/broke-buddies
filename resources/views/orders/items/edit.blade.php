<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div x-data="shoppingCart({{ json_encode($cartItems) }})" class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="text-lg font-semibold">
                        {{ __($order->shop->name) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 flex">
                        <!-- Shop Items Section -->
                        <div class="w-3/4 pr-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="font-semibold text-lg">Shop Items</h3>
                                <div class="w-1/4">
                                    <div x-data="searchComponent()">
                                        <input type="text" placeholder="Search items..."
                                            class="border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring focus:ring-blue-500"
                                            @input="getData($event.target.value)" />
                                    </div>
                                </div>
                            </div>
                            <div class="max-h-96 overflow-y-auto p-4">
                                @foreach ($order->shop->shopCategories as $category)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-lg mb-2">{{ $category->name }}</h4>
                                        <div
                                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                            @foreach ($category->items as $item)
                                                <div
                                                    class="bg-gray-100 p-4 rounded-lg shadow transition-transform transform hover:scale-105">
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
                            <div class="max-h-96 overflow-y-auto min-h-[400px]">
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
                                                <x-danger-button type="button" @click="removeFromCart(index)"
                                                    class="ml-2 p-1 text-xs">
                                                    ×
                                                </x-danger-button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4 flex items-center">
                                <span class="font-semibold text-lg mr-2">Total:</span>
                                <span class="font-bold text-lg" x-text="`$${totalPrice.toFixed(2)}`"></span>
                                <div class="ml-auto">
                                    <x-primary-button class="ml-2" x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'update-order-items')">{{ __('Update Your Order') }}</x-primary-button>
                                    <x-modal name="update-order-items" focusable>
                                        <form method="POST"
                                            action="{{ route('order-items.update', [$order->id, $order->shop->id]) }}"
                                            class="p-6" x-data="{ extraFees: 0 }">
                                            @method('PUT')
                                            @csrf
                                            <h2 class="text-lg font-medium text-gray-900 mb-3">
                                                {{ __('Are you sure you want to update your order?') }}
                                            </h2>

                                            <table class="min-w-full bg-white">
                                                <thead>
                                                    <tr
                                                        class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                                        <th class="py-3 px-6 text-left">Item Name</th>
                                                        <th class="py-3 px-6 text-left">Price</th>
                                                        <th class="py-3 px-6 text-left">Quantity</th>
                                                        <th class="py-3 px-6 text-left">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600 text-sm font-light">
                                                    <template x-for="(cartItem, index) in cart" :key="index">
                                                        <tr class="border-b hover:bg-gray-100">
                                                            <td class="py-3 px-6 text-left" x-text="cartItem.name"></td>
                                                            <td class="py-3 px-6 text-left"
                                                                x-text="`$${cartItem.price.toFixed(2)}`"></td>
                                                            <td class="py-3 px-6 text-left">
                                                                <span x-text="cartItem.quantity"></span>
                                                            </td>
                                                            <td class="py-3 px-6 text-left"
                                                                x-text="`$${(cartItem.price * cartItem.quantity).toFixed(2)}`">
                                                            </td>
                                                        </tr>
                                                    </template>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="py-3 px-6 text-right font-semibold">
                                                            Sub Total Price:
                                                        </td>
                                                        <td class="py-3 px-6 text-left"
                                                            x-text="`$${totalPrice.toFixed(2)}`"></td>
                                                    </tr>

                                                    @foreach ($order->fees as $fee)
                                                        <tr>
                                                            <td colspan="3"
                                                                class="py-3 px-6 text-right font-semibold">
                                                                {{ $fee->name }}:
                                                            </td>
                                                            <td class="py-3 px-6 text-left">
                                                                {{ number_format($fee->price / ($order->orderUsers()->count() ?: 1), 2) }}
                                                                / decrease if others join.
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr>
                                                        <td colspan="3" class="py-3 px-6 text-right font-semibold">
                                                            Total Price:
                                                        </td>
                                                        <td class="py-3 px-6 text-left"
                                                            x-text="`$${(totalPrice + {{ $order->orderFeesTotalPrice() / ($order->orderUsers()->count() ?: 1) }}).toFixed(2)}`">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="py-1 px-6 text-right">
                                                            <p class="text-sm text-gray-500 mt-1">
                                                                <strong class="font-semibold text-black">Note:</strong>
                                                                May be Order Admin Add or Update <strong
                                                                    class="font-semibold text-black">Extra
                                                                    Fees</strong> Before Order Submitted.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <input name="order_id" value="{{ $order->id }}" hidden>
                                            <template x-for="(cartItem, index) in cart" :key="index">
                                                <div>
                                                    <input type="hidden" :name="'items[' + index + '][shop_item_id]'"
                                                        x-model="cartItem.id">
                                                    <input type="hidden" :name="'items[' + index + '][quantity]'"
                                                        x-model="cartItem.quantity">
                                                    <input type="hidden" :name="'items[' + index + '][price]'"
                                                        x-model="cartItem.price">
                                                </div>
                                            </template>

                                            <div class="mt-6 flex justify-end">
                                                <x-secondary-button x-on:click="$dispatch('close')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>

                                                <x-primary-button type="submit" class="ml-3">
                                                    {{ __('Update My Order') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </x-modal>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div x-show="showToast" x-transition
            class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded shadow-lg" style="display: none;"
            x-init="setTimeout(() => { showToast = false }, 3000)">
            <span x-text="message"></span>
        </div>
    </div>

    <script>
        function shoppingCart(initialCart = []) {
            return {
                cart: initialCart.map(item => ({
                    id: item.shop_item_id,
                    name: `${item.name} [${item.size}] $${item.price}`,
                    price: parseFloat(item.price),
                    quantity: item.quantity
                })),
                selectedSizes: {},
                prices: {},
                totalPrice: 0,
                showToast: false,
                message: '',

                updatePrice(itemId) {
                    const selectedOption = document.querySelector(
                        `select[x-model="selectedSizes[${itemId}]"] option:checked`);
                    const price = selectedOption ? parseFloat(selectedOption.value) : 0;
                    this.prices[itemId] = price.toFixed(2);
                },

                addToCart(itemId, event) {
                    const selectedSize = this.selectedSizes[itemId];
                    const selectedOption = event.target.closest('.bg-gray-100').querySelector(
                        `select[x-model="selectedSizes[${itemId}]"] option:checked`);
                    const itemName = selectedOption ? selectedOption.dataset.name : '';
                    const sizeName = selectedOption ? selectedOption.dataset.size : '';
                    const price = selectedOption ? parseFloat(selectedOption.value) : 0;

                    // Validation: Check if size is selected
                    if (!selectedSize) {
                        this.showToast = true;
                        this.message = 'Please select a size before adding to the cart.';
                        return;
                    }

                    // Create a unique identifier for the cart item using both name and size
                    const uniqueItemName = `${itemName} [${sizeName}] $${price}`;

                    // Check if the item is already in the cart
                    const existingItem = this.cart.find(item => item.name === uniqueItemName);
                    if (existingItem) {
                        existingItem.quantity++;
                    } else {
                        this.cart.push({
                            id: itemId,
                            name: uniqueItemName,
                            price: price,
                            quantity: 1
                        });
                    }

                    // Update total price
                    this.updateTotalPrice();

                    // Log cart items
                    this.logCartItems();
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    this.updateTotalPrice();
                    this.showToast = true;
                    this.message = 'Item removed from cart.';
                },

                updateTotalPrice() {
                    this.totalPrice = this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
                },

                logCartItems() {
                    console.log("Cart Items:", this.cart);
                }
            };
        }

        function searchComponent() {
            return {
                results: [],
                async getData(searchTerm) {
                    const url = `http://localhost:8000/api/shop-items/search/${searchTerm}`;
                    try {
                        const response = await fetch(url, {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        });

                        if (!response.ok) {
                            throw new Error(`Response status: ${response.status}`);
                        }

                        const json = await response.json();
                        console.log(json);
                    } catch (error) {
                        console.error(error.message);
                        this.results = [];
                    }
                }
            };
        }
    </script>
</x-app-layout>
