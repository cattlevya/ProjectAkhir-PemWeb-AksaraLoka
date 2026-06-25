@extends('layouts.seller')

@section('title', 'Artisan Settings | AksaraLoka Seller')

@section('content')
<div class="px-4 py-8 max-w-5xl mx-auto">
    <header class="mb-12">
        <span class="text-brand-brown font-bold text-xs uppercase tracking-[0.3em] block mb-2 font-['Manrope']">Settings & Identity</span>
        <h1 class="text-5xl font-black tracking-tight text-brand-indigo font-['Epilogue']">Artisan Profile</h1>
        <p class="text-on-surface-variant mt-2 font-medium font-['Manrope']">Manage your personal credentials and heritage store identity.</p>
    </header>

    <div class="space-y-12">
        {{-- 1. Personal Credentials --}}
        <section class="bg-surface-container-low p-10 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-brand-indigo/10 rounded-xl flex items-center justify-center text-brand-indigo">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-brand-indigo font-['Epilogue']">Personal Information</h2>
                        <p class="text-xs text-on-surface-variant font-medium font-['Manrope'] uppercase tracking-widest">Login & Contact Details</p>
                    </div>
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">Legal Name</label>
                            <input id="name" name="name" type="text" 
                                   class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20" 
                                   value="{{ old('name', $user->name) }}" required autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">Email Address</label>
                            <input id="email" name="email" type="email" 
                                   class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20" 
                                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="bg-brand-indigo text-brand-ochre px-8 py-4 rounded-xl font-bold tracking-tight hover:opacity-90 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue']">
                            Update Credentials
                        </button>

                        @if (session('status') === 'profile-updated')
                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                  class="ml-4 text-sm font-bold text-brand-brown font-['Manrope']">
                                ✓ Personal info updated
                            </span>
                        @endif
                    </div>
                </form>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] opacity-[0.03] text-brand-indigo select-none">badge</span>
        </section>

        {{-- 2. Store Identity Section --}}
        <section class="bg-surface-container-low p-10 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-brand-ochre/10 rounded-xl flex items-center justify-center text-brand-ochre">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-brand-indigo font-['Epilogue']">Artisan Identity</h2>
                        <p class="text-xs text-on-surface-variant font-medium font-['Manrope'] uppercase tracking-widest">How customers see your brand</p>
                    </div>
                </div>

                <form method="post" action="{{ route('seller.store.update') }}" enctype="multipart/form-data" class="space-y-8 max-w-4xl">
                    @csrf
                    @method('patch')

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                        <div class="lg:col-span-4 flex flex-col items-center">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 mb-4 self-start ml-2">Artisan Logo</label>
                            <div class="relative group cursor-pointer w-full aspect-square bg-surface-bright rounded-2xl border-2 border-dashed border-outline-variant/30 flex flex-center transition-all hover:border-brand-brown overflow-hidden" onclick="document.getElementById('logo-upload').click()">
                                @if($store->logo)
                                    <img src="{{ asset('storage/' . $store->logo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center justify-center p-8 text-center text-brand-indigo/30">
                                        <span class="material-symbols-outlined text-4xl mb-4">add_photo_alternate</span>
                                        <p class="text-xs font-bold font-['Manrope']">UPLOAD LOGO</p>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-brand-indigo/80 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all text-white">
                                    <span class="text-xs font-bold uppercase tracking-widest">Change Image</span>
                                </div>
                            </div>
                            <input type="file" id="logo-upload" name="logo" class="hidden" accept="image/*">
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        <div class="lg:col-span-8 space-y-6">
                            <div class="space-y-2">
                                <label for="store_name" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">Heritage Store Name</label>
                                <input id="store_name" name="store_name" type="text" 
                                       class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20" 
                                       value="{{ old('store_name', $store->store_name) }}" placeholder="e.g. Rahayu Heritage Batik" required />
                                <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <label for="description" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">Artisan Bio / Story</label>
                                <textarea id="description" name="description" rows="4"
                                          class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20"
                                          placeholder="Share your heritage story with your collectors...">{{ old('description', $store->description) }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-outline-variant/20">
                        <button type="submit" 
                                class="bg-brand-indigo text-brand-ochre px-8 py-4 rounded-xl font-bold tracking-tight hover:opacity-90 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue']">
                            Save Identity
                        </button>

                        @if (session('status') === 'store-updated')
                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                  class="ml-4 text-sm font-bold text-brand-brown font-['Manrope']">
                                ✓ Store information secured
                            </span>
                        @endif
                    </div>
                </form>
            </div>
            <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[180px] opacity-[0.03] text-brand-indigo select-none">auto_awesome</span>
        </section>

        {{-- 3. Security Section --}}
        <section class="bg-surface-container-low p-10 rounded-3xl border border-outline-variant/20 shadow-xl relative overflow-hidden group">
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 bg-brand-brown/10 rounded-xl flex items-center justify-center text-brand-brown">
                        <span class="material-symbols-outlined">security</span>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-brand-indigo font-['Epilogue']">Security Settings</h2>
                        <p class="text-xs text-on-surface-variant font-medium font-['Manrope'] uppercase tracking-widest">Password & Protection</p>
                    </div>
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6 max-w-2xl">
                    @csrf
                    @method('put')

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label for="current_password" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-brown ml-1">Current Password</label>
                            <input id="current_password" name="current_password" type="password" 
                                   class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all" 
                                   autocomplete="current-password" />
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="password" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">New Password</label>
                                <input id="password" name="password" type="password" 
                                       class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20" 
                                       autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div class="space-y-2">
                                <label for="password_confirmation" class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-indigo/60 ml-1">Confirm Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password" 
                                       class="w-full bg-surface-bright border-2 border-outline-variant/30 rounded-xl px-4 py-4 font-bold text-brand-indigo focus:border-brand-brown outline-none transition-all placeholder:text-brand-indigo/20" 
                                       autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-outline-variant/20">
                        <button type="submit" 
                                class="bg-brand-brown text-brand-cream px-8 py-4 rounded-xl font-bold tracking-tight hover:opacity-90 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue']">
                            Update Password
                        </button>

                        @if (session('status') === 'password-updated')
                            <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                  class="ml-4 text-sm font-bold text-brand-brown font-['Manrope']">
                                ✓ Password updated successfully
                            </span>
                        @endif
                    </div>
                </form>
            </div>
            <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-[120px] opacity-[0.03] text-brand-brown select-none">key</span>
        </section>
    </div>

    {{-- Danger Zone --}}
    <div class="mt-24 pt-12 border-t border-outline-variant/30">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 bg-red-50/50 p-10 rounded-3xl border border-red-100">
            <div class="max-w-xl">
                <h3 class="text-xl font-black text-red-900 font-['Epilogue'] uppercase tracking-tight">Danger Zone</h3>
                <p class="text-red-700/70 mt-1 font-medium font-['Manrope']">Deleting your account is permanent. All your heritage pieces, store data, and sales history will be removed forever.</p>
            </div>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    class="bg-red-600 text-white px-8 py-4 rounded-xl font-bold tracking-tight hover:bg-red-700 transition-all shadow-lg active:scale-95 border-none cursor-pointer font-['Epilogue'] shrink-0 text-center">
                Delete Account
            </button>
        </div>
    </div>
</div>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Are you sure you want to delete your account?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
        </p>

        <div class="mt-6">
            <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-3/4"
                placeholder="{{ __('Password') }}"
            />

            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
@endsection
