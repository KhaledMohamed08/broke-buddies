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
                        {{ __('All Orders') }}
                    </div>
                    <form action="{{ route('dashboard') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" placeholder="Search Orders..."
                            class="border border-gray-300 rounded-l-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-blue-500 h-10" />
                        <x-primary-button type="submit" class="rounded-l-none h-10 px-4">
                            {{ __('Search') }}
                        </x-primary-button>
                    </form>
                </div>
                <div class="overflow-x-auto max-h-64">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Code</th>
                                <th class="py-3 px-6 text-left">Shop</th>
                                <th class="py-3 px-6 text-left">Creator</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-left">Ends at</th>
                                <th class="py-3 px-6 text-center">#</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($orders as $order)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">{{ $order->code }}</td>
                                    <td class="py-3 px-6 text-left">{{ $order->shop->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $order->user->name }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-sm font-semibold text-{{ App\Enums\OrderStatusEnum::from($order->status)->badge() }}-800 bg-{{ App\Enums\OrderStatusEnum::from($order->status)->badge() }}-200 rounded-full">
                                            {{ App\Enums\OrderStatusEnum::from($order->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $order->ends_at }}</td>
                                    @if ($order->status == 1)
                                        <td class="py-3 px-6 text-center">
                                            <x-primary-button>
                                                <a href="{{ route('orders.join', $order->id) }}">{{ __('Join Order') }}</a>
                                            </x-primary-button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div class="text-lg font-semibold">
                        {{ __('My Orders') }}
                    </div>
                </div>
                <div class="overflow-x-auto max-h-64">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Code</th>
                                <th class="py-3 px-6 text-left">Shop</th>
                                <th class="py-3 px-6 text-left">Creator</th>
                                <th class="py-3 px-6 text-left">Status</th>
                                <th class="py-3 px-6 text-left">Ends at</th>
                                <th class="py-3 px-6 text-center">#</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">
                            @foreach ($authOrders as $order)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">{{ $order->code }}</td>
                                    <td class="py-3 px-6 text-left">{{ $order->shop->name }}</td>
                                    <td class="py-3 px-6 text-left">{{ $order->user->name }}</td>
                                    <td class="py-3 px-6 text-left">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-sm font-semibold text-{{ App\Enums\OrderStatusEnum::from($order->status)->badge() }}-800 bg-{{ App\Enums\OrderStatusEnum::from($order->status)->badge() }}-200 rounded-full">
                                            {{ App\Enums\OrderStatusEnum::from($order->status)->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6 text-left">{{ $order->ends_at }}</td>
                                    <td class="py-3 px-6">
                                        <x-primary-button x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'edit-user-order{{ $order->id }}')">{{ __('Edit Order') }}</x-primary-button>

                                        <x-modal name="edit-user-order{{ $order->id }}" focusable>
                                            <form method="POST" action="{{ route('orders.update', $order->id) }}" class="p-6">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-4">
                                                    <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                                    <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                                        @foreach (App\Enums\OrderStatusEnum::cases() as $status)
                                                            <option value="{{ $status->value }}" {{ $status->value == $order->status ? 'selected' : '' }}>
                                                                {{ $status->label() }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="ends_at" class="block text-sm font-medium text-gray-700">{{ __('Ends at') }}</label>
                                                    <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at', $order->ends_at) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                                                </div>

                                                <!-- Notes Textarea -->
                                                <div class="mb-4">
                                                    <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                                    <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $order->notes) }}</textarea>
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
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit" class="mt-4 ml-2">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 w-full mr-4 flex flex-col items-center">
                    <h3 class="text-lg font-semibold">{{ __('Create Order') }}</h3>
                    <p class="mt-2 text-gray-600 text-center">{{ __('Quickly create a new order for your shop.') }}</p>
                    <x-primary-button class="mt-4" x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'create-order')">{{ __('Create Order') }}</x-primary-button>

                    <x-modal name="create-order" focusable>
                        <form method="POST" action="{{ route('orders.store') }}" class="p-6">
                            @csrf
                            <div class="mb-4">
                                <label for="shop" class="block text-sm font-medium text-gray-700">{{ __('Shop') }}</label>
                                <select id="shop" name="shop_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}">
                                            {{ $shop->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="ends_at" class="block text-sm font-medium text-gray-700">{{ __('Ends at') }}</label>
                                <input type="datetime-local" id="ends_at" name="ends_at" value="{{ old('ends_at', $order->ends_at) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            </div>

                            <!-- Notes Textarea -->
                            <div class="mb-4">
                                <label for="notes" class="block text-sm font-medium text-gray-700">{{ __('Notes') }}</label>
                                <textarea id="notes" name="notes" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-primary-button class="ms-3">
                                    {{ __('Create Order') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </x-modal>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 w-full ml-4 flex flex-col items-center">
                    <h3 class="text-lg font-semibold">{{ __('Create Shop') }}</h3>
                    <p class="mt-2 text-gray-600 text-center">{{ __('Start a new shop to sell your products.') }}</p>
                    <x-primary-button class="mt-4">
                        <a href="{{ route('shops.create') }}">{{ __('Create Shop') }}</a>
                    </x-primary-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



<div class="w-3/4 pr-4">
    <h3 class="font-semibold text-lg mb-4">Shop Items</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <div class="font-bold">name</div>
                {{-- drop down for sizes --}}
                {{-- price --}}
                <div class="mt-2">
                    <x-primary-button>
                        <a href="#">{{ __('add to cart') }}</a>
                    </x-primary-button>
                </div>
            </div>
    </div>
</div>