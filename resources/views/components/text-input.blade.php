@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-brand-primary/10 bg-brand-white/80 focus:border-brand-primary focus:ring-brand-primary rounded-xl shadow-sm transition-all duration-200']) }}>
