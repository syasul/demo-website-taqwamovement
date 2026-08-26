<x-guest-layout>
    <!-- Page Header -->
    <div class="mb-8 text-center">
        <h2 class="font-serif text-h2 font-bold text-brand-primary">Selamat Datang</h2>
        <p class="text-caption text-brand-ink/65 mt-1">Silakan masuk untuk melanjutkan ke akun Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div class="space-y-1.5">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold text-brand-primary uppercase tracking-wider" />
            <x-text-input id="email" class="block w-full bg-brand-white/50 border border-brand-primary/10 rounded-xl px-4 py-3 text-body" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <div class="flex justify-between items-center">
                <x-input-label for="password" :value="__('Password')" class="text-xs font-semibold text-brand-primary uppercase tracking-wider" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-brand-secondary hover:text-brand-primary hover:underline transition-colors" href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block w-full bg-brand-white/50 border border-brand-primary/10 rounded-xl px-4 py-3 text-body"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Actions -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-brand-primary/20 text-brand-primary shadow-sm focus:ring-brand-accent w-4 h-4" name="remember">
                <span class="ms-2 text-xs font-medium text-brand-ink/65 select-none">Ingat saya</span>
            </label>
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full py-3.5 text-body font-bold rounded-xl">
                Masuk ke Akun
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
