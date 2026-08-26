@props([
    'id',
    'title' => null
])

<div 
    x-data="{ isOpen: false }"
    x-show="isOpen"
    @open-modal.window="if ($event.detail === '{{ $id }}') isOpen = true"
    @close-modal.window="if ($event.detail === '{{ $id }}') isOpen = false"
    @keydown.escape.window="isOpen = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
    role="dialog"
    aria-modal="true"
    aria-labelledby="modal-title-{{ $id }}"
>
    <!-- Dark Backdrop overlay -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-brand-ink/40 backdrop-blur-sm transition-opacity" 
        @click="isOpen = false"
    ></div>
    
    <!-- Modal Dialog Body -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div 
            x-show="isOpen"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-brand-white rounded-2xl shadow-2xl max-w-lg w-full p-6 md:p-8 overflow-hidden transform transition-all border border-brand-blush-lt/30"
        >
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-brand-blush-lt/20">
                <h3 id="modal-title-{{ $id }}" class="font-serif text-h3 font-bold text-brand-primary">
                    {{ $title }}
                </h3>
                <button 
                    @click="isOpen = false" 
                    type="button"
                    class="text-brand-ink/50 hover:text-brand-primary focus:outline-none p-1 rounded-lg hover:bg-brand-blush-lt/10"
                    aria-label="Close modal"
                >
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Main Slot -->
            <div class="text-body text-brand-ink/75 leading-relaxed">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
