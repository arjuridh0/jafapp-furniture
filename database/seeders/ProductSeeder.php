<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Kursi
            [
                'category' => 'kursi',
                'name' => 'Kursi Tamu Ukir Jepara',
                'description' => 'Kursi tamu mewah dengan ukiran khas Jepara. Dibuat dari kayu jati pilihan grade A dengan finishing natural. Cocok untuk ruang tamu yang luas dan elegan.',
                'dimensions' => '65x60x100 cm',
                'price' => 3500000,
                'stock' => 10,
            ],
            [
                'category' => 'kursi',
                'name' => 'Kursi Makan Minimalis Jati',
                'description' => 'Kursi makan minimalis dari kayu jati solid. Desain modern dan nyaman untuk penggunaan sehari-hari. Finishing melamine coating tahan air.',
                'dimensions' => '45x50x90 cm',
                'price' => 1200000,
                'stock' => 20,
            ],
            // Meja
            [
                'category' => 'meja',
                'name' => 'Meja Makan 6 Kursi Jati',
                'description' => 'Set meja makan untuk 6 orang dari kayu jati solid. Permukaan meja halus dengan finishing natural glossy. Kuat dan tahan lama.',
                'dimensions' => '180x90x75 cm',
                'price' => 8500000,
                'stock' => 5,
            ],
            [
                'category' => 'meja',
                'name' => 'Meja Kerja Minimalis',
                'description' => 'Meja kerja minimalis cocok untuk home office. Dilengkapi laci penyimpanan. Kayu jati grade A dengan finishing natural.',
                'dimensions' => '120x60x75 cm',
                'price' => 2800000,
                'stock' => 15,
            ],
            // Lemari
            [
                'category' => 'lemari',
                'name' => 'Lemari Pakaian 3 Pintu Jati',
                'description' => 'Lemari pakaian 3 pintu dari kayu jati solid. Dilengkapi cermin, gantungan baju, dan rak dalam. Ukiran klasik Jepara di bagian depan.',
                'dimensions' => '150x60x200 cm',
                'price' => 12000000,
                'stock' => 3,
            ],
            [
                'category' => 'lemari',
                'name' => 'Buffet TV Minimalis Jati',
                'description' => 'Buffet TV minimalis modern dari kayu jati. Desain simpel dan fungsional dengan ruang penyimpanan luas.',
                'dimensions' => '150x45x50 cm',
                'price' => 4500000,
                'stock' => 8,
            ],
            // Tempat Tidur
            [
                'category' => 'tempat-tidur',
                'name' => 'Dipan Ukir Raja Jepara',
                'description' => 'Tempat tidur king size dengan ukiran detail khas Jepara. Kayu jati pilihan dengan finishing premium. Termasuk sandaran kepala dan kaki ukir.',
                'dimensions' => '200x180x120 cm',
                'price' => 15000000,
                'stock' => 2,
            ],
            [
                'category' => 'tempat-tidur',
                'name' => 'Tempat Tidur Minimalis Queen',
                'description' => 'Tempat tidur queen size desain minimalis. Kayu jati solid dengan finishing natural. Kokoh dan elegan.',
                'dimensions' => '200x160x90 cm',
                'price' => 7500000,
                'stock' => 6,
            ],
            // Rak
            [
                'category' => 'rak',
                'name' => 'Rak Buku Dinding Jati',
                'description' => 'Rak buku dinding dari kayu jati. Desain floating shelf minimalis. Set berisi 3 buah dengan ukuran berbeda.',
                'dimensions' => '80x25x20 cm',
                'price' => 1500000,
                'stock' => 12,
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('slug', $productData['category'])->first();

            if ($category) {
                Product::firstOrCreate(
                    ['slug' => \Illuminate\Support\Str::slug($productData['name'])],
                    [
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'description' => $productData['description'],
                        'dimensions' => $productData['dimensions'],
                        'price' => $productData['price'],
                        'stock' => $productData['stock'],
                        'images' => [],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}
