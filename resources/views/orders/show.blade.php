<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Order Code Section -->
            <div class="bg-white shadow-lg rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ __('Order Code: ' . $order->code) }}
                    </h3>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ __('Shop Name: ' . $order->shop->name) }}
                    </h3>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">
                        {{ __('Shop Phone: ' . $order->shop->phone) }}
                    </h3>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <p class="font-semibold text-sm text-gray-600">
                            {{ __('Order Users Count: ' . $order->orderUsers()->count()) }}
                        </p>
                        <p class="text-lg font-semibold text-gray-800 mt-2 md:mt-0">
                            {{ __('Order Total Price: $' . $order->orderTotalPrice()) }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons Section -->
            <div class="mb-6">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Actions') }}</h4>
                <div class="flex space-x-4">
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'edit-user-order{{ $order->id }}')">{{ __('Edit Order') }}</x-primary-button>

                    <x-modal name="edit-user-order{{ $order->id }}" focusable>
                        <form method="POST" action="{{ route('orders.update', $order->id) }}" class="p-6">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="status"
                                    class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <select id="status" name="status"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @foreach (App\Enums\OrderStatusEnum::cases() as $status)
                                        <option value="{{ $status->value }}"
                                            {{ $status->value == $order->status ? 'selected' : '' }}>
                                            {{ $status->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="ends_at"
                                    class="block text-sm font-medium text-gray-700">{{ __('Ends at') }}</label>
                                <input type="datetime-local" id="ends_at" name="ends_at"
                                    value="{{ old('ends_at', $order->ends_at) }}"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                    required>
                            </div>

                            <!-- Notes Textarea -->
                            <div class="mb-4">
                                <label for="notes"
                                    class="block text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                <textarea id="notes" name="notes" rows="4"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $order->notes) }}</textarea>
                            </div>

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-primary-button class="ms-3">
                                    {{ __('Apply') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                    <x-primary-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'add-fees-user-order{{ $order->id }}')">{{ __('Add Fees To Order') }}</x-primary-button>

                    <x-modal name="add-fees-user-order{{ $order->id }}" focusable>
                        <form method="POST" action="#" class="p-6">
                            @csrf

                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-primary-button class="ms-3">
                                    {{ __('Apply') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                    <x-danger-button class="ml-2" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'delete-user-order{{ $order->id }}')">{{ __('Delete Order') }}</x-danger-button>
                    <x-modal name="delete-user-order{{ $order->id }}" focusable>
                        <form method="POST" action="{{ route('orders.destroy', $order->id) }}" class="p-6">
                            @csrf
                            @method('DELETE')
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your order?') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your order is deleted, all of its resources and data will be permanently deleted.') }}
                            </p>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3">
                                    {{ __('Delete') }}
                                </x-danger-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            </div>

            <!-- Order Items Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6 border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Order Items') }}</h4>
                <div class="flex flex-wrap gap-4">
                    @foreach ($order->orderItemsDetails() as $item)
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-300 flex flex-col w-48">
                            <p class="text-gray-600">{{ __('Item ID: ') }}{{ $item['item_details']->item->id }}</p>
                            <p class="text-gray-800 font-semibold">{{ $item['item_details']->item->name }}</p>
                            <p class="text-gray-500">{{ __('Size: ') }}{{ $item['item_details']->size }}</p>
                            <p class="text-gray-600">
                                {{ __('Price: $') }}{{ number_format($item['item_details']->price, 2) }}</p>
                            <p class="text-gray-600">{{ __('Quantity: ') }}{{ $item['quantity'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Users Items Section -->
            <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                <h4 class="text-lg font-semibold text-gray-800 mb-4">{{ __('Users Items') }}</h4>
                @foreach ($order->orderUsers() as $user)
                    <div class="mb-4">
                        <h5 class="font-semibold text-md text-gray-800 mb-2">{{ $user->name }}</h5>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($user->orderItemsForOrderId($order->id) as $item)
                                <div class="bg-gray-50 p-4 rounded-md border border-gray-300 flex flex-col w-48">
                                    <p class="text-gray-600">{{ __('Item ID: ') }}{{ $item->item->id }}</p>
                                    <p class="text-gray-800 font-semibold">{{ $item->item->name }}</p>
                                    <p class="text-gray-500">{{ __('Size: ') }}{{ $item->itemDetails->size }}</p>
                                    <p class="text-gray-600">
                                        {{ __('Price: $') }}{{ number_format($item->itemDetails->price, 2) }}</p>
                                    <p class="text-gray-600">{{ __('Quantity: ') }}{{ $item->quantity }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
