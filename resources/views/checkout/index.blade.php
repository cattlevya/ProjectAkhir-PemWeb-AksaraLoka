<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Checkout | AksaraLoka</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              colors: {
                  "tertiary-fixed-dim": "#ffb77c",
                  "on-tertiary-fixed": "#2e1500",
                  "surface-container-highest": "#e4e4cc",
                  "error-container": "#ffdad6",
                  "error": "#ba1a1a",
                  "on-primary": "#ffffff",
                  "tertiary": "#331800",
                  "surface-container-high": "#eaead1",
                  "on-tertiary-fixed-variant": "#6d3900",
                  "on-tertiary": "#ffffff",
                  "secondary-fixed-dim": "#ffb68c",
                  "secondary-fixed": "#ffdbc9",
                  "secondary": "#934b19",
                  "primary-fixed": "#e0e0ff",
                  "inverse-primary": "#c1c3ed",
                  "secondary-container": "#ffa26a",
                  "surface-container-low": "#f5f5dc",
                  "outline": "#77767e",
                  "on-error": "#ffffff",
                  "surface-bright": "#fbfbe2",
                  "on-secondary": "#ffffff",
                  "surface-container-lowest": "#ffffff",
                  "on-secondary-fixed-variant": "#753401",
                  "on-secondary-fixed": "#321200",
                  "on-primary-container": "#9799c0",
                  "on-surface": "#1b1d0e",
                  "on-tertiary-container": "#df8731",
                  "on-primary-fixed-variant": "#414466",
                  "tertiary-fixed": "#ffdcc2",
                  "surface": "#fbfbe2",
                  "primary-fixed-dim": "#c1c3ed",
                  "on-surface-variant": "#46464e",
                  "inverse-surface": "#303221",
                  "surface-variant": "#e4e4cc",
                  "inverse-on-surface": "#f2f2d9",
                  "surface-tint": "#595c7f",
                  "primary": "#191c3c",
                  "primary-container": "#2e3152",
                  "on-secondary-container": "#783603",
                  "on-primary-fixed": "#151938",
                  "surface-dim": "#dbdcc3",
                  "outline-variant": "#c7c5cf",
                  "background": "#fbfbe2",
                  "on-error-container": "#93000a",
                  "tertiary-container": "#512900",
                  "surface-container": "#efefd7",
                  "on-background": "#1b1d0e"
              },
              fontFamily: {
                  "headline": ["Epilogue"],
                  "body": ["Manrope"],
                  "label": ["Manrope"]
              }
            }
          }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body {
            background-color: #fbfbe2;
            color: #1b1d0e;
        }
    </style>
</head>
<body class="font-body selection:bg-secondary-container selection:text-on-secondary-container relative">

    <!-- Header (Suppressed Nav Shell as per Checkout Policy) -->
    <header class="w-full flex justify-between items-center px-8 py-6 z-50">
        <h1 class="text-2xl font-black text-primary tracking-tighter font-headline">
            <a href="{{ route('home') }}" class="text-primary no-underline">AksaraLoka Checkout</a>
        </h1>
        <div class="flex items-center gap-4">
            <span class="text-xs uppercase tracking-[0.2em] font-bold text-secondary hidden md:inline">Secured Journey</span>
            <span class="material-symbols-outlined text-primary">lock</span>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 md:px-12 pb-24 pt-4">
        <!-- Artisan Breadcrumb -->
        <div class="flex items-center gap-4 mb-12">
            <a href="{{ route('cart.index') }}" class="text-sm font-bold text-secondary uppercase tracking-widest font-label hover:underline">Cart</a>
            <div class="h-[1px] w-10 bg-outline-variant opacity-20"></div>
            <span class="text-sm font-black text-primary uppercase tracking-widest font-label">Shipping Details</span>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Column: Checkout Actions -->
                <div class="lg:col-span-8 space-y-16">
                    
                    <!-- Section 1: Address Selection -->
                    <section>
                        <div class="flex items-baseline justify-between mb-6">
                            <h2 class="text-3xl font-black font-headline tracking-tight text-primary">Alamat Pengiriman</h2>
                        </div>
                        <div class="bg-surface-container-high rounded-xl p-6 ring-2 ring-transparent focus-within:ring-secondary transition-all">
                            <span class="text-[10px] font-bold text-secondary uppercase tracking-[0.15em] mb-3 block">Alamat Tujuan</span>
                            <textarea name="shipping_address" rows="3" required
                                      class="w-full bg-transparent border-none p-0 text-sm focus:ring-0 text-primary font-medium"
                                      placeholder="Masukkan alamat lengkap pengiriman anda (Jalan, RT/RW, Kabupaten, Kodepos)...">{{ old('shipping_address', auth()->user()->address ?? '') }}</textarea>
                            @error('shipping_address')
                                <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <!-- Section 2: Order Items -->
                    <section>
                        <h2 class="text-3xl font-black font-headline tracking-tight text-primary mb-8">Keranjang Anda</h2>
                        <div class="space-y-6">
                            @foreach($cartItems as $productId => $item)
                            <div class="bg-surface-container-low rounded-lg p-6 lg:p-8 overflow-hidden relative">
                                <div class="flex gap-6 relative">
                                    <div class="w-24 h-32 bg-surface-container-highest shrink-0 overflow-hidden rounded-lg border border-outline-variant/20">
                                        <img src="{{ $item['image'] ?? 'https://via.placeholder.com/150' }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover"/>
                                    </div>
                                    <div class="flex-1 flex flex-col justify-center">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-bold text-lg text-primary tracking-tight line-clamp-1 pr-4">{{ $item['name'] }}</h4>
                                            <p class="font-black text-secondary font-headline shrink-0">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                        </div>
                                        <div class="mt-auto flex items-center gap-4">
                                            <div class="flex items-center gap-2 px-3 py-1 bg-surface-container rounded-full text-xs font-black text-primary">
                                                Qty: {{ $item['qty'] }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </section>

                    <!-- Section 3: Payment Type -->
                    <section>
                        <h2 class="text-2xl font-black font-headline tracking-tight text-primary mb-6">Metode Pembayaran</h2>
                        <div class="space-y-4 max-w-md">
                            <label class="block p-4 rounded-lg bg-surface-container-high ring-2 ring-primary/10 flex items-center gap-4 cursor-pointer hover:bg-surface-container transition-all">
                                <input checked class="text-secondary focus:ring-secondary border-outline" name="payment_method" type="radio" value="bank_transfer"/>
                                <div class="flex-1">
                                    <p class="font-bold text-primary text-sm">Direct Bank Transfer</p>
                                    <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-medium">BCA - Manual Verification</p>
                                </div>
                                <span class="material-symbols-outlined text-outline">account_balance</span>
                            </label>
                        </div>
                    </section>

                    <!-- Section 4: Transfer Proof -->
                    <section>
                        <h2 class="text-2xl font-black font-headline tracking-tight text-primary mb-6">Transfer Proof</h2>
                        <div class="bg-surface-container-high border-2 border-dashed border-secondary/30 rounded-2xl p-8 flex flex-col items-center justify-center text-center group hover:border-secondary transition-all cursor-pointer relative"
                             onclick="document.getElementById('proof_upload').click()">
                            
                            <div class="w-16 h-16 bg-secondary-fixed rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-secondary text-3xl">cloud_upload</span>
                            </div>
                            
                            <h3 class="font-bold text-primary mb-1">Upload Receipt</h3>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-medium mb-6">JPG, PNG, OR PDF (MAX 5MB)</p>
                            
                            <button type="button" class="px-6 py-2 bg-primary text-on-primary text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-primary-container transition-colors">
                                Select File
                            </button>
                            
                            <input type="file" name="payment_proof" id="proof_upload" class="hidden" accept="image/*,.pdf"
                                   required onchange="updateFileName(this)"/>
                            
                            <div id="file-name-preview" class="mt-4 text-xs font-bold text-secondary hidden italic">
                                <!-- File name will appear here -->
                            </div>
                        </div>
                        @error('payment_proof')
                            <p class="text-error text-xs mt-2 font-bold">{{ $message }}</p>
                        @enderror
                    </section>
                </div>

                <!-- Right Column: Order Summary (Sticky Sidebar) -->
                <aside class="lg:col-span-4 sticky top-12">
                    <div class="bg-surface-container-high p-8 rounded-2xl shadow-sm border border-outline-variant/10">
                        <h3 class="text-xl font-black font-headline text-primary tracking-tight mb-8">Ringkasan</h3>
                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-sm">
                                <span class="text-primary/60 font-medium">Subtotal</span>
                                <span class="text-primary font-bold">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-primary/60 font-medium">Platform Fee</span>
                                <span class="text-primary font-bold">Rp 0</span>
                            </div>
                            <div class="h-[1px] w-full bg-outline-variant opacity-20 my-6"></div>
                            <div class="flex justify-between items-baseline">
                                <span class="text-xs uppercase font-black text-primary tracking-widest">Total</span>
                                <span class="text-3xl font-black text-secondary font-headline">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="p-4 bg-primary text-on-primary rounded-xl mb-8 border border-white/10">
                            <div class="flex items-center gap-3 mb-2 opacity-80">
                                <span class="material-symbols-outlined text-secondary-container">payments</span>
                                <p class="text-xs font-bold uppercase tracking-widest">Rekening Tujuan</p>
                            </div>
                            <p class="text-lg font-black mb-1 font-headline tracking-widest">801 234 5678</p>
                            <p class="text-[10px] opacity-70 uppercase tracking-widest font-bold">A/N AksaraLoka PLATFORM</p>
                        </div>

                        <button type="submit" class="w-full py-5 bg-gradient-to-r from-primary to-primary-container text-on-primary font-black uppercase tracking-[0.2em] text-xs rounded-xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-primary/20 border-none cursor-pointer">
                            Buat Pesanan
                        </button>
                        
                        <div class="mt-8 flex flex-col items-center gap-2">
                            <div class="flex items-center gap-1 text-[10px] font-bold text-primary/40 uppercase tracking-widest">
                                <span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">verified_user</span>
                                Keamanan Terjamin
                            </div>
                            <p class="text-[10px] text-center text-on-surface-variant leading-relaxed opacity-60">
                                Menyelesaikan pesanan berarti menyetujui syarat & ketentuan pengelola pelapak platform ini.
                            </p>
                        </div>
                    </div>
                </aside>
                
            </div>
        </form>
    </main>

    <!-- Visual Texture / Subtle Decoration -->
    <div class="fixed top-0 right-0 -z-10 w-1/3 h-full opacity-5 pointer-events-none">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/canvas-orange.png')]"></div>
        <div class="w-full h-full bg-gradient-to-b from-secondary/20 to-transparent"></div>
    </div>

    <script>
        function updateFileName(input) {
            const preview = document.getElementById('file-name-preview');
            if (input.files && input.files[0]) {
                preview.textContent = 'Selected: ' + input.files[0].name;
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
