<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |----------------------------------------------------------------------
        | 1. USERS — 3 roles (admin, penjual, pembeli)
        |----------------------------------------------------------------------
        */
        $admin = User::create([
            'name' => 'Admin AksaraLoka',
            'email' => 'admin@aksaraloka.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567890',
            'address' => 'Jl. Jenderal Soedirman No. 1, Purwokerto, Banyumas',
        ]);

        $penjual1 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@aksaraloka.id',
            'password' => Hash::make('password'),
            'role' => 'penjual',
            'phone' => '081234567891',
            'address' => 'Jl. Batik No. 15, Sokaraja, Banyumas',
        ]);

        $penjual2 = User::create([
            'name' => 'Bambang Wijaya',
            'email' => 'bambang@aksaraloka.id',
            'password' => Hash::make('password'),
            'role' => 'penjual',
            'phone' => '081234567892',
            'address' => 'Jl. Raya Baturaden No. 22, Banyumas',
        ]);

        $pembeli = User::create([
            'name' => 'Rina Susanti',
            'email' => 'rina@email.com',
            'password' => Hash::make('password'),
            'role' => 'pembeli',
            'phone' => '081234567893',
            'address' => 'Jl. Merdeka No. 5, Purwokerto, Banyumas',
        ]);

        /*
        |----------------------------------------------------------------------
        | 2. STORES — 2 toko penjual
        |----------------------------------------------------------------------
        */
        $store1 = Store::create([
            'user_id' => $penjual1->id,
            'store_name' => 'Rahayu Heritage Batik',
            'description' => 'A premier studio dedicated to the preservation of Banyumasan Batik Tulis. We specialize in intricate motifs and natural dyes, connecting modern collectors with the soul of Javanese textile art.',
            'address' => 'Jl. Batik No. 15, Sokaraja, Banyumas',
        ]);

        $store2 = Store::create([
            'user_id' => $penjual2->id,
            'store_name' => 'Banyumas Botanical & Culinary',
            'description' => 'Discover the authentic flavors and natural harvests of the Serayu Valley. From traditional slow-cooked snacks to highland specialty coffee, we bring the best of Banyumas to your table.',
            'address' => 'Jl. Raya Baturaden No. 22, Banyumas',
        ]);

        /*
        |----------------------------------------------------------------------
        | 3. CATEGORIES — 5 kategori (Slugs adjusted to match HomeController expectations and navbar)
        |----------------------------------------------------------------------
        */
        $catWastra = Category::create(['name' => 'Wastra & Kerajinan', 'slug' => 'wastra']);
        $catKuliner = Category::create(['name' => 'Kuliner Nusantara', 'slug' => 'kuliner']);

        /*
        |----------------------------------------------------------------------
        | 4. PRODUCTS — 8 produk realistis dengan gambar
        |----------------------------------------------------------------------
        */

        // ===== TOKO 1: Wastra (Siti Rahayu) =====
        $wastraData = [
            [
                'name' => 'Hand-Drawn Batik Motif Lumbon (Indigo)',
                'description' => "A masterpiece of Banyumasan heritage. This Batik Tulis (hand-drawn) features the traditional 'Lumbon' motif, meticulously crafted with natural indigo and soga brown dyes. Each piece takes weeks of patient waxing and dyeing by artisans in Sokaraja.",
                'image' => '/images/products/batik_indigo_lumbon.png', 'price' => 1250000, 'stock' => 5, 'weight' => 250
            ],
            [
                'name' => 'Premium Tenun Lurik Banyumas',
                'description' => "Traditional hand-loomed (ATBM) Lurik fabric from the heart of Banyumas. Featuring subtle, elegant stripe patterns in earthy tones. Perfect for bespoke garments or high-end interior accents.",
                'image' => '/images/products/tenun_lurik_banyumas.png', 'price' => 450000, 'stock' => 15, 'weight' => 400
            ],
            [
                'name' => 'Masterfully Carved Wayang Kayu',
                'description' => "A professional craftsmanship piece. Hand-carved from seasoned teak wood, this Wayang puppet represents the soul of Javanese storytelling. A timeless addition to any curated archive.",
                'image' => '/images/products/wayang_kayu_ukir.png', 'price' => 875000, 'stock' => 3, 'weight' => 800
            ],
            [
                'name' => 'Artisan Silk Tenun Scarf',
                'description' => "A luxurious blend of premium silk and traditional weaving techniques. This scarf features subtle Banyumas motifs with a sophisticated sheen, offering a touch of heritage to modern elegance.",
                'image' => '/images/products/syal_tenun_silk.png', 'price' => 625000, 'stock' => 10, 'weight' => 150
            ],
            [
                'name' => 'Eksklusif Indigo Silk Scarf (Limited Edition)',
                'description' => "Our most prestigious textile. A limited edition silk scarf hand-dyed with deep mountain indigo. Light-as-air texture with intricate hand-drawn heritage patterns. Truly one of a kind.",
                'image' => '/images/products/limited_batik_scarf.png', 'price' => 1850000, 'stock' => 2, 'weight' => 100
            ],
            [
                'name' => 'Heritage Teak Serving Bowl',
                'description' => "Hand-carved from a single block of premium Banyumas teak. Features a rich, deep wood grain with a food-safe natural wax finish. A functional piece of art for the modern home.",
                'image' => '/images/products/teak_bowl.png', 'price' => 550000, 'stock' => 8, 'weight' => 1200
            ],
            [
                'name' => 'Organic Terracotta Artisan Vase',
                'description' => "Hand-thrown pottery by local masters. This terracotta vase features a rough-hewn, matte ochre finish with subtle traditional carvings inspired by ancient Javanese artifacts.",
                'image' => '/images/products/terracotta_vase.png', 'price' => 325000, 'stock' => 12, 'weight' => 1500
            ],
        ];

        foreach ($wastraData as $index => $data) {
            $product = Product::create([
                'store_id' => $store1->id,
                'category_id' => $catWastra->id,
                'name' => $data['name'],
                'slug' => \Illuminate\Support\Str::slug($data['name']),
                'description' => $data['description'] . "\n\n100% Authentic artisan craft from Banyumas.",
                'price' => $data['price'],
                'stock' => $data['stock'],
                'weight' => $data['weight'],
                'is_active' => true,
            ]);
            ProductImage::create(['product_id' => $product->id, 'image_path' => $data['image'], 'is_primary' => true]);
        }

        // ===== TOKO 2: Kuliner (Bambang) =====
        $kulinerData = [
            [
                'name' => 'Artisan Gethuk Goreng Sokaraja',
                'description' => "The most iconic sweet from Banyumas. Made from choice cassava and premium palm sugar, deep-fried to a perfect golden crisp while remaining soft and legit on the inside. Served in a traditional bamboo basket.",
                'image' => '/images/products/getuk_goreng_sokaraja.png', 'price' => 65000, 'stock' => 50, 'weight' => 500
            ],
            [
                'name' => 'Signature Nopia Banyumas',
                'description' => "Crispy-skinned traditional pastries filled with oozing authentic brown sugar. Toasted to perfection in a clay oven (gentong), giving it a unique smoky artisanal aroma.",
                'image' => '/images/products/nopia_banyumas.png', 'price' => 45000, 'stock' => 40, 'weight' => 400
            ],
            [
                'name' => 'Premium Tempe Mendoan (Artisan Plating)',
                'description' => "A legendary Banyumas delicacy. Thin slices of aged soy tempeh, batter-dipped with aromatic herbs and flash-fried. Best enjoyed with our signature bird's eye chili sweet soy sauce.",
                'image' => '/images/products/mendoan_banyumas.png', 'price' => 35000, 'stock' => 100, 'weight' => 350
            ],
            [
                'name' => 'Cinematic Sroto Sokaraja',
                'description' => "A rich, savory heritage soup featuring a complex peanut-based broth, tender beef, and traditional Cantir crackers. A bowl of warmth and history in every sip.",
                'image' => '/images/products/soto_sokaraja.png', 'price' => 45000, 'stock' => 50, 'weight' => 500
            ],
            [
                'name' => 'Banyumas Estate Specialty Coffee',
                'description' => "Hand-picked beans from the slopes of Mount Slamet. Medium-dark roast with notes of chocolate and mountain spice. Freshly roasted in small batches to preserve its authentic Juru origin.",
                'image' => '/images/products/banyumas_coffee.png', 'price' => 155000, 'stock' => 20, 'weight' => 250
            ],
        ];

        $kulinerModels = [];
        foreach ($kulinerData as $index => $data) {
            $product = Product::create([
                'store_id' => $store2->id,
                'category_id' => $catKuliner->id,
                'name' => $data['name'],
                'slug' => \Illuminate\Support\Str::slug($data['name']),
                'description' => $data['description'] . "\n\nTanpa pengawet buatan. Cita rasa kebanggaan Banyumas.",
                'price' => $data['price'],
                'stock' => $data['stock'],
                'weight' => $data['weight'],
                'is_active' => true,
            ]);
            ProductImage::create(['product_id' => $product->id, 'image_path' => $data['image'], 'is_primary' => true]);
            $kulinerModels[] = $product;
        }

        $p5 = $kulinerModels[0]; // Getuk
        $p7 = $kulinerModels[2]; // Mendoan

        /*
        |----------------------------------------------------------------------
        | 5. SAMPLE ORDER — 1 pesanan dari pembeli
        |----------------------------------------------------------------------
        */
        $order = Order::create([
            'order_code' => 'UMKM-20260418-A1B2C',
            'buyer_id' => $pembeli->id,
            'total_amount' => 118000,
            'shipping_address' => 'Jl. Merdeka No. 5, RT 03/RW 02, Kel. Purwokerto Wetan, Kec. Purwokerto Timur, Banyumas, Jawa Tengah 53115',
            'status' => 'menunggu_pembayaran',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p5->id,
            'store_id' => $store2->id,
            'qty' => 2,
            'price' => 45000,
            'subtotal' => 90000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $p7->id,
            'store_id' => $store2->id,
            'qty' => 1,
            'price' => 28000,
            'subtotal' => 28000,
        ]);

        echo "✅ Seeder berhasil! Data created:\n";
        echo "   - 4 Users (admin/penjual/pembeli)\n";
        echo "   - 2 Stores\n";
        echo "   - 5 Categories\n";
        echo "   - 8 Products with images\n";
        echo "   - 1 Sample Order\n";
        echo "\n📧 Login credentials:\n";
        echo "   Admin:   admin@aksaraloka.id  / password\n";
        echo "   Penjual: siti@aksaraloka.id   / password\n";
        echo "   Penjual: bambang@aksaraloka.id / password\n";
        echo "   Pembeli: rina@email.com    / password\n";
    }
}
