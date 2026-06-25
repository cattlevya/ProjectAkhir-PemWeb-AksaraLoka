<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ProductImage;

class AksaraLokaPremiumSeeder extends Seeder
{
    public function run()
    {
        // Bersihkan data lama
        ProductImage::truncate();
        Product::query()->delete();

        // 1. Create Core Categories
        $wastraCategory = Category::firstOrCreate(
            ['slug' => 'wastra'],
            ['name' => 'Wastra & Kerajinan']
        );

        $kulinerCategory = Category::firstOrCreate(
            ['slug' => 'kuliner'],
            ['name' => 'Kuliner Nusantara']
        );

        // 2. Create sample seller
        $sellerUser = User::firstOrCreate([
            'email' => 'artisan@banyumas.id',
        ], [
            'name' => 'Artisan Banyumas',
            'password' => bcrypt('password'),
            'role' => 'penjual',
        ]);

        $store = Store::firstOrCreate([
            'user_id' => $sellerUser->id,
        ], [
            'store_name' => 'Atelier Banyumas',
        ]);

        // 3. Wastra Products
        $wastraData = [
            [
                'name' => 'Batik Tulis Banyumasan',
                'description' => 'Batik tulis asli motif cempaka mulya khas Banyumas, dibuat dengan teknik pewarnaan tradisional dari alam.',
                'image' => '/images/dummy/batik.png',
                'price' => 750000
            ],
            [
                'name' => 'Tenun Serayu Murni',
                'description' => 'Kain tenun helaian benang emas dan sutra yang ditenun perlahan oleh perajin di tepian Kali Serayu.',
                'image' => '/images/dummy/tenun.png',
                'price' => 950000
            ],
            [
                'name' => 'Lurik Wangi Klasik',
                'description' => 'Kain lurik dengan pola garis-garis klasik bernuansa monokrom, nyaman dipakai dan sarat akan cerita warisan luhur.',
                'image' => '/images/dummy/lurik.png',
                'price' => 450000
            ],
            [
                'name' => 'Kerajinan Bambu Papringan',
                'description' => 'Wadah anyaman bambu premium dan presisi, dikerjakan berbulan-bulan oleh maestro kriya asal Banyumas.',
                'image' => '/images/dummy/bambu.png',
                'price' => 250000
            ]
        ];

        foreach ($wastraData as $data) {
            $product = Product::create([
                'store_id' => $store->id,
                'category_id' => $wastraCategory->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => rand(2, 8),
                'weight' => rand(500, 1000),
                'is_active' => true,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $data['image'],
                'is_primary' => true,
            ]);
        }

        // 4. Kuliner Products
        $kulinerData = [
            [
                'name' => 'Mendoan Banyumas Premium',
                'description' => 'Tempe mendoan setengah matang khas Purwokerto yang digoreng dengan tepung bumbu warisan tersohor, disajikan eksklusif.',
                'image' => '/images/dummy/mendoan.png',
                'price' => 35000
            ],
            [
                'name' => 'Getuk Goreng Sokaraja',
                'description' => 'Kudapan getuk goreng renyah di luar, manis dan lembut di dalam terbuat dari singkong pilihan dan gula kelapa alami.',
                'image' => '/images/dummy/getuk.png',
                'price' => 45000
            ],
            [
                'name' => 'Soto Sokaraja Authentic',
                'description' => 'Kelezat soto khas Sokaraja dengan kuah pekat kaldu daging, sambal kacang legit, dan kerupuk cantir ikan kualitas tinggi.',
                'image' => '/images/dummy/soto.png',
                'price' => 55000
            ],
            [
                'name' => 'Nopia Baturraden Heritage',
                'description' => 'Roti manis tradisional berongga khas Banyumas berisi gula merah lumer yang dipanggang lambat dengan tungku bata.',
                'image' => '/images/dummy/nopia.png',
                'price' => 40000
            ]
        ];

        foreach ($kulinerData as $data) {
            $product = Product::create([
                'store_id' => $store->id,
                'category_id' => $kulinerCategory->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'stock' => rand(15, 50),
                'weight' => rand(200, 600),
                'is_active' => true,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $data['image'],
                'is_primary' => true,
            ]);
        }
    }
}
