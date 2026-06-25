<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — AksaraLoka</title>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&family=Manrope:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#191c3c",
            "primary-container": "#2e3152",
            "secondary": "#934b19",
            "secondary-container": "#ffa26a",
            "surface": "#fbfbe2",
            "surface-container-low": "#f5f5dc",
            "surface-container": "#efefd7",
            "surface-container-high": "#eaead1",
            "surface-container-highest": "#e4e4cc",
            "surface-variant": "#e4e4cc",
            "background": "#fbfbe2",
            "on-surface": "#1b1d0e",
            "on-surface-variant": "#46464e",
            "on-background": "#1b1d0e",
            "on-primary": "#ffffff",
            "on-primary-container": "#9799c0",
            "on-secondary": "#ffffff",
            "outline": "#77767e",
            "outline-variant": "#c7c5cf",
            "error": "#ba1a1a",
            "primary-fixed": "#e0e0ff",
          },
          borderRadius: {
            DEFAULT: "0.125rem",
            lg: "0.25rem",
            xl: "0.5rem",
            full: "0.75rem",
          },
          fontFamily: {
            headline: ["Epilogue"],
            body: ["Manrope"],
            label: ["Manrope"],
          },
        },
      },
    }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .artisan-gradient {
            background: linear-gradient(135deg, #191c3c 0%, #2e3152 100%);
        }
    </style>
</head>
<body class="bg-surface font-body text-on-surface selection:bg-secondary-container selection:text-on-surface">
    <main class="min-h-screen flex flex-col md:flex-row overflow-hidden">
        {{-- Left Side: Editorial Art Canvas --}}
        <section class="hidden md:flex md:w-5/12 lg:w-1/2 bg-primary-container relative flex-col justify-between p-12 overflow-hidden">
            <div class="absolute inset-0 opacity-40 mix-blend-overlay">
                <img alt="Pemandangan Banyumas" class="w-full h-full object-cover"
                     src="{{ asset('images/dummy/register_editorial.png') }}"/>
            </div>
            <div class="relative z-10">
                <div class="mb-12">
                    <a href="{{ route('home') }}" class="font-headline text-4xl font-black tracking-tighter text-surface uppercase">AksaraLoka</a>
                </div>
                <div class="max-w-md">
                    <h2 class="font-headline text-6xl font-extrabold text-surface tracking-tighter leading-[0.9] mb-6">JADILAH<br/>BAGIAN KAMI.</h2>
                    <p class="text-on-primary-container font-medium text-lg leading-relaxed">Bergabunglah dengan jaringan eksklusif kolektor dan pengrajin yang melestarikan jiwa kerajinan Banyumasan.</p>
                </div>
            </div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="h-[1px] w-12 bg-outline-variant opacity-30"></div>
                <span class="font-label text-xs uppercase tracking-[0.2em] text-on-primary-container">Est. 2024 • Banyumas, Jawa Tengah</span>
            </div>
        </section>

        {{-- Right Side: Registration Form --}}
        <section class="flex-1 flex flex-col justify-center items-center px-6 py-12 md:px-16 lg:px-24 bg-surface relative">
            {{-- Mobile Brand Logo --}}
            <div class="md:hidden absolute top-8 left-8">
                <a href="{{ route('home') }}" class="font-headline text-xl font-black tracking-tighter text-primary uppercase">AksaraLoka</a>
            </div>

            <div class="w-full max-w-md">
                <header class="mb-12">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="font-label text-xs font-extrabold text-secondary uppercase tracking-[0.15em]">Registrasi</span>
                        <div class="h-[1px] flex-1 bg-outline-variant opacity-20"></div>
                    </div>
                    <h1 class="font-headline text-4xl font-bold text-primary tracking-tight">Buat akun Anda</h1>
                    <p class="text-on-surface-variant mt-2">Sudah punya akun?
                        <a class="text-secondary font-bold hover:underline decoration-2 underline-offset-4 transition-all" href="{{ route('login') }}">Masuk di sini</a>
                    </p>
                </header>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    {{-- Name Input --}}
                    <div class="space-y-2">
                        <label class="font-label text-xs font-bold text-on-surface-variant uppercase tracking-widest" for="name">Nama Lengkap</label>
                        <input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant/30 focus:border-secondary focus:ring-0 px-0 py-3 transition-colors placeholder:text-on-surface-variant/40 font-medium"
                               id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               placeholder="Contoh: Raden Mas" type="text"/>
                        @error('name') <p class="text-error text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Email Input --}}
                    <div class="space-y-2">
                        <label class="font-label text-xs font-bold text-on-surface-variant uppercase tracking-widest" for="email">Alamat Email</label>
                        <input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant/30 focus:border-secondary focus:ring-0 px-0 py-3 transition-colors placeholder:text-on-surface-variant/40 font-medium"
                               id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               placeholder="nama@email.com" type="email"/>
                        @error('email') <p class="text-error text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    {{-- Grid for Passwords --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="font-label text-xs font-bold text-on-surface-variant uppercase tracking-widest" for="password">Kata Sandi</label>
                            <input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant/30 focus:border-secondary focus:ring-0 px-0 py-3 transition-colors placeholder:text-on-surface-variant/40 font-medium"
                                   id="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••" type="password"/>
                            @error('password') <p class="text-error text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="font-label text-xs font-bold text-on-surface-variant uppercase tracking-widest" for="password_confirmation">Konfirmasi</label>
                            <input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant/30 focus:border-secondary focus:ring-0 px-0 py-3 transition-colors placeholder:text-on-surface-variant/40 font-medium"
                                   id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••" type="password"/>
                        </div>
                    </div>

                    {{-- Terms & Conditions --}}
                    <div class="flex items-start gap-3 pt-2">
                        <div class="flex items-center h-5">
                            <input class="h-4 w-4 rounded-sm border-outline-variant text-secondary focus:ring-secondary/20 transition-all" id="terms" name="terms" type="checkbox"/>
                        </div>
                        <label class="text-sm text-on-surface-variant leading-tight" for="terms">
                            Saya setuju dengan <a class="text-primary font-bold hover:underline" href="#">Ketentuan Layanan</a> dan mengakui <a class="text-primary font-bold hover:underline" href="#">Kebijakan Privasi</a>.
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button class="artisan-gradient w-full py-5 text-surface font-headline font-bold uppercase tracking-[0.2em] text-sm hover:opacity-90 active:scale-[0.98] transition-all shadow-xl shadow-primary/10" type="submit">
                            Buat Akun
                        </button>
                    </div>
                </form>

                {{-- Social Divider --}}
                <div class="relative my-10">
                    <div aria-hidden="true" class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-outline-variant/20"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase tracking-widest">
                        <span class="bg-surface px-4 text-on-surface-variant/60 font-bold">Atau daftar dengan</span>
                    </div>
                </div>

                {{-- Social Icons --}}
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-3 py-3 border-b-2 border-outline-variant/20 hover:border-secondary transition-colors group">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                        </svg>
                        <span class="font-label text-[10px] font-extrabold uppercase tracking-widest text-on-surface-variant group-hover:text-primary">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-3 py-3 border-b-2 border-outline-variant/20 hover:border-secondary transition-colors group">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                        </svg>
                        <span class="font-label text-[10px] font-extrabold uppercase tracking-widest text-on-surface-variant group-hover:text-primary">Facebook</span>
                    </button>
                </div>

                {{-- Footer Footnote --}}
                <footer class="mt-16 text-center">
                    <p class="font-label text-[10px] text-on-surface-variant/40 uppercase tracking-[0.25em]">Mengkurasi tekstil dan kuliner terbaik Banyumasan sejak era digital.</p>
                </footer>
            </div>
        </section>
    </main>

    {{-- Heritage Decorative Element (Asymmetry) --}}
    <div class="fixed top-0 right-0 p-8 pointer-events-none hidden lg:block">
        <div class="w-24 h-24 border-t border-r border-secondary/20"></div>
    </div>
    <div class="fixed bottom-0 left-0 p-8 pointer-events-none hidden lg:block">
        <div class="w-24 h-24 border-b border-l border-secondary/20"></div>
    </div>
</body>
</html>
