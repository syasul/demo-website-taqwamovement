<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-brand-primary border border-transparent rounded-full font-medium tracking-wide text-brand-white shadow-sm hover:bg-brand-secondary focus:bg-brand-secondary active:bg-brand-primary focus:outline-none focus:ring-2 focus:ring-brand-accent focus:ring-offset-2 transition-all duration-300 hover:-translate-y-[1px]']) }}>
    {{ $slot }}
</button>
