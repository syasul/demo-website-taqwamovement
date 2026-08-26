@props([
    'title',
    'open' => false
])

<div 
    x-data="{ isOpen: {{ $open ? 'true' : 'false' }} }" 
    {{ $attributes->merge(['class' => 'border border-brand-blush-lt/30 rounded-xl overflow-hidden bg-brand-white shadow-[0_4px_15px_rgba(80,46,136,0.02)] transition-all duration-300']) }}
>
    <!-- Toggle Header -->
    <button 
        @click="isOpen = !isOpen" 
        type="button"
        class="w-full flex items-center justify-between p-5 md:p-6 font-serif font-bold text-brand-primary text-body-lg text-left focus:outline-none focus:bg-brand-blush-lt/10"
        :aria-expanded="isOpen.toString()"
    >
        <span>{{ $title }}</span>
        <svg 
            class="w-5 h-5 text-brand-secondary transition-transform duration-300 shrink-0 ml-4"
            :class="isOpen ? 'rotate-180' : ''"
            fill="none" 
            stroke="currentColor" 
            viewBox="0 0 24 24"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <!-- Body Content Panel -->
    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 max-h-0"
        x-transition:enter-end="opacity-100 max-h-[1000px]"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 max-h-[1000px]"
        x-transition:leave-end="opacity-0 max-h-0"
        class="px-5 pb-5 md:px-6 md:pb-6 pt-0 text-body text-brand-ink/75 leading-relaxed"
    >
        <div class="pt-4 border-t border-brand-blush-lt/10">
            {{ $slot }}
        </div>
    </div>
</div>
