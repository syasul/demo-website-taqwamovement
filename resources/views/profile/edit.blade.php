@if(auth()->check() && in_array(auth()->user()->role, ['super-admin', 'editor']))
    <x-layouts.admin>
        @section('page_title', 'Profil Saya')

        <div class="space-y-8 max-w-3xl">
            <!-- Profile Info Card -->
            <div class="bg-brand-white border border-slate-200 p-8 rounded-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Card -->
            <div class="bg-brand-white border border-slate-200 p-8 rounded-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account Card -->
            <div class="bg-brand-white border border-slate-200 p-8 rounded-3xl shadow-[0_1px_3px_rgba(0,0,0,0.02)]">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </x-layouts.admin>
@else
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-serif text-h2 font-bold text-brand-primary leading-tight">
                {{ __('Profile') }}
            </h2>
        </x-slot>

        <div class="py-12 bg-brand-cream min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                <div class="p-8 bg-brand-white border border-slate-200 shadow-sm rounded-3xl max-w-3xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="p-8 bg-brand-white border border-slate-200 shadow-sm rounded-3xl max-w-3xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="p-8 bg-brand-white border border-slate-200 shadow-sm rounded-3xl max-w-3xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </x-app-layout>
@endif
