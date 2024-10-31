<div x-data="{ open: false, message: '', type: '' }" 
     x-init="
        @if (session('success')) 
            message = '{{ session('success') }}'; 
            type = 'success'; 
            open = true; 
        @elseif (session('fail')) 
            message = '{{ session('fail') }}'; 
            type = 'fail'; 
            open = true; 
        @endif
        if (open) {
            setTimeout(() => { open = false; }, 3000);
        }
     " 
     x-show="open" 
     @click.away="open = false" 
     class="fixed top-5 right-5 z-50" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="transform opacity-0 scale-95"
     x-transition:enter-end="transform opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="transform opacity-100 scale-100"
     x-transition:leave-end="transform opacity-0 scale-95">

    <div :class="type === 'success' ? 'bg-green-500' : 'bg-red-500'" 
         class="text-white text-lg font-semibold px-6 py-4 rounded shadow-lg w-full max-w-xs text-center">
        <span x-text="message"></span>
        <button @click="open = false" class="ml-4 text-white hover:text-gray-200">
            &times;
        </button>
    </div>
</div>
