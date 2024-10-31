<div x-data="{ selected: '{{ old($name) }}' || '' }">
    <select x-model="selected" name="{{ $name }}" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        <option value="" disabled selected>Select an option</option>
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}" x-bind:selected="selected === '{{ $option['value'] }}'">{{ $option['label'] }}</option>
        @endforeach
    </select>

    <p x-show="selected" class="mt-2 text-sm text-gray-600">You selected: <span x-text="selected"></span></p>
</div>
