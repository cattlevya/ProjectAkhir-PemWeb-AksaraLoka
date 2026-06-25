<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — AksaraLoka</title>
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
        .bg-batik-mesh {
            background-color: #fbfbe2;
            background-image: radial-gradient(at 0% 0%, #efefd7 0px, transparent 50%),
                              radial-gradient(at 100% 100%, #e4e4cc 0px, transparent 50%);
        }
    </style>
</head>
<body class="bg-background text-on-background font-body min-h-screen flex flex-col">
    {{-- Top Bar --}}
    <header class="w-full px-8 py-10 flex justify-center md:justify-start items-center">
        <a href="{{ route('home') }}" class="text-2xl font-black text-primary tracking-tighter uppercase font-headline">AksaraLoka</a>
    </header>

    <main class="flex-grow flex flex-col md:flex-row-reverse items-stretch w-full">
        {{-- Visual Section (Editorial Sidebar) --}}
        <section class="hidden md:flex md:w-1/2 lg:w-3/5 bg-surface-container-low p-12 justify-center items-center relative overflow-hidden">
            <div class="absolute inset-0 z-0 bg-batik-mesh opacity-50"></div>
            <div class="relative z-10 w-full max-w-2xl aspect-[4/5] bg-surface shadow-2xl p-4 md:p-8 transform rotate-1">
                <div class="w-full h-full relative overflow-hidden bg-surface-container-high">
                    <img class="w-full h-full object-cover grayscale-[20%] sepia-[10%]"
                         src="{{ asset('images/dummy/login_editorial.png') }}"
                         alt="Pengrajin Batik Banyumas"/>
                    <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-primary/80 to-transparent">
                        <p class="font-headline text-surface font-bold text-4xl leading-tight tracking-tighter uppercase">
                            Melestarikan Jiwa<br/>Banyumas.
                        </p>
                    </div>
                </div>
            </div>
            {{-- Decorative Asymmetric Element --}}
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-secondary/10 rounded-full blur-3xl"></div>
        </section>

        {{-- Login Form Section --}}
        <section class="flex-grow flex items-center justify-center px-6 py-12 md:px-16 lg:px-24">
            <div class="w-full max-w-md space-y-10">
                {{-- Headline Stack --}}
                <div class="space-y-2">
                    <div class="flex items-center gap-4">
                        <span class="text-secondary font-label text-sm font-bold tracking-[0.2em] uppercase">Autentikasi</span>
                        <div class="h-[1px] w-12 bg-outline-variant/30"></div>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-headline font-extrabold text-primary tracking-tighter">Selamat datang.</h2>
                    <p class="text-on-surface-variant opacity-80 max-w-xs">Akses koleksi terkurasi dan wawasan pengrajin Banyumas Anda.</p>
                </div>

                @if(session('status'))
                    <div class="bg-primary-fixed text-primary p-4 rounded-lg text-sm">{{ session('status') }}</div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="space-y-4">
                        <div class="group">
                            <label class="block text-[10px] font-bold text-primary uppercase tracking-widest mb-1" for="email">Alamat Email</label>
                            <input class="w-full bg-transparent border-b border-outline-variant/50 border-t-0 border-x-0 px-0 py-3 focus:ring-0 focus:border-secondary transition-colors font-body text-primary placeholder:text-outline-variant"
                                   id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                   placeholder="nama@email.com" type="email"/>
                            @error('email') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div class="group">
                            <div class="flex justify-between items-center mb-1">
                                <label class="block text-[10px] font-bold text-primary uppercase tracking-widest" for="password">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a class="text-[10px] font-bold text-secondary uppercase tracking-widest hover:underline" href="{{ route('password.request') }}">Lupa?</a>
                                @endif
                            </div>
                            <input class="w-full bg-transparent border-b border-outline-variant/50 border-t-0 border-x-0 px-0 py-3 focus:ring-0 focus:border-secondary transition-colors font-body text-primary placeholder:text-outline-variant"
                                   id="password" name="password" required autocomplete="current-password"
                                   placeholder="••••••••" type="password"/>
                            @error('password') <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="h-4 w-4 rounded-sm border-outline-variant text-secondary focus:ring-secondary/20 transition-all">
                        <label for="remember_me" class="ml-2 text-sm font-medium text-on-surface-variant font-label tracking-wide">Ingat saya</label>
                    </div>

                    <button class="w-full bg-primary text-surface font-headline font-bold uppercase tracking-widest py-5 rounded-lg hover:bg-primary-container active:scale-[0.98] transition-all flex justify-center items-center gap-3" type="submit">
                        Masuk
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="relative flex items-center py-4">
                    <div class="flex-grow border-t border-outline-variant/20"></div>
                    <span class="flex-shrink mx-4 font-label text-[10px] font-bold text-outline-variant uppercase tracking-widest">Atau masuk dengan</span>
                    <div class="flex-grow border-t border-outline-variant/20"></div>
                </div>

                {{-- Social Login --}}
                <div class="grid grid-cols-2 gap-4">
                    <button class="flex items-center justify-center gap-3 py-4 border border-outline-variant/30 rounded hover:bg-surface-container-low transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"></path>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"></path>
                        </svg>
                        <span class="font-label text-[10px] font-bold uppercase tracking-widest text-primary">Google</span>
                    </button>
                    <button class="flex items-center justify-center gap-3 py-4 border border-outline-variant/30 rounded hover:bg-surface-container-low transition-colors">
                        <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.99 22 12c0-5.523-4.477-10-10-10z"></path>
                        </svg>
                        <span class="font-label text-[10px] font-bold uppercase tracking-widest text-primary">Facebook</span>
                    </button>
                </div>

                {{-- Footer Link --}}
                <div class="pt-8 text-center">
                    <p class="text-on-surface-variant font-body text-sm">
                        Belum punya akun?
                        <a class="text-secondary font-bold hover:underline ml-1" href="{{ route('register') }}">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    <footer class="w-full px-8 py-8 flex flex-col md:flex-row justify-between items-center gap-4 bg-surface text-on-surface-variant/60">
        <div class="font-label text-[10px] font-bold uppercase tracking-widest">
            © {{ date('Y') }} AksaraLoka Banyumasan
        </div>
        <div class="flex gap-6">
            <a class="font-label text-[10px] font-bold uppercase tracking-widest hover:text-secondary" href="#">Privasi</a>
            <a class="font-label text-[10px] font-bold uppercase tracking-widest hover:text-secondary" href="#">Ketentuan</a>
            <a class="font-label text-[10px] font-bold uppercase tracking-widest hover:text-secondary" href="#">Bantuan</a>
        </div>
    </footer>
</body>
</html>
