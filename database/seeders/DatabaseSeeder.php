<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CustomOrder;
use App\Models\Payment;
use App\Models\ProductionLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === USERS ===
        $superadmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@jafapp.test',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'phone' => '081234567890',
            'is_active' => true,
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Admin Sari',
            'email' => 'admin@jafapp.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081234567891',
            'is_active' => true,
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);

        $budi = User::create([
            'name' => 'Budi Pelanggan',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567892',
            'address' => 'Jl. Pemuda No. 10, Semarang, Jawa Tengah',
            'is_active' => true,
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);

        $citra = User::create([
            'name' => 'Citra Pelanggan',
            'email' => 'citra@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '081234567894',
            'address' => 'Jl. Dago No. 45, Bandung, Jawa Barat',
            'is_active' => true,
            'is_guest' => false,
            'email_verified_at' => now(),
        ]);

        $andi = User::create([
            'name' => 'Andi Guest',
            'email' => 'andi@guest.com',
            'password' => Hash::make('password_guest_random'),
            'role' => 'customer',
            'phone' => '081234567893',
            'address' => 'Jl. Malioboro No. 12, Yogyakarta',
            'is_active' => false,
            'is_guest' => true,
            'email_verified_at' => null,
        ]);

        // === CATEGORIES ===
        $categories = [
            ['name' => 'Kursi', 'slug' => 'kursi'],
            ['name' => 'Meja', 'slug' => 'meja'],
            ['name' => 'Lemari', 'slug' => 'lemari'],
            ['name' => 'Tempat Tidur', 'slug' => 'tempat-tidur'],
            ['name' => 'Rak', 'slug' => 'rak'],
            ['name' => 'Aksesoris', 'slug' => 'aksesoris'],
        ];

        $catModels = [];
        foreach ($categories as $cat) {
            $catModels[$cat['slug']] = Category::create($cat);
        }

        // === PRODUCTS ===
        $products = [
            [
                'category_id' => $catModels['kursi']->id,
                'name' => 'Kursi Tamu Jati Ukir Klasik',
                'slug' => 'kursi-tamu-jati-ukir-klasik',
                'description' => 'Kursi tamu mewah berbahan kayu jati pilihan dengan ukiran klasik Jepara. Cocok untuk ruang tamu rumah atau kantor. Finishing melamin natural yang menonjolkan serat kayu jati asli.',
                'dimensions' => '120x60x85 cm',
                'price' => 4500000,
                'stock' => 5,
                'images' => json_encode(['products/kursi-tamu-klasik.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['kursi']->id,
                'name' => 'Kursi Makan Jati Minimalis',
                'slug' => 'kursi-makan-jati-minimalis',
                'description' => 'Kursi makan modern minimalis dari kayu jati solid. Desain simpel namun elegan, cocok untuk dining set keluarga. Kuat dan tahan lama.',
                'dimensions' => '45x50x90 cm',
                'price' => 1200000,
                'stock' => 12,
                'images' => json_encode(['products/kursi-makan-minimalis.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['meja']->id,
                'name' => 'Meja Makan Jati 6 Kursi',
                'slug' => 'meja-makan-jati-6-kursi',
                'description' => 'Meja makan besar dari kayu jati massif untuk 6 orang. Permukaan halus dengan finishing natural. Kaki meja kokoh dengan desain modern.',
                'dimensions' => '160x90x75 cm',
                'price' => 5800000,
                'stock' => 3,
                'images' => json_encode(['products/meja-makan-6-kursi.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['meja']->id,
                'name' => 'Meja Kerja Jati Modern',
                'slug' => 'meja-kerja-jati-modern',
                'description' => 'Meja kerja minimalis dari kayu jati dengan laci penyimpanan. Desain clean dan fungsional untuk ruang kerja di rumah atau kantor.',
                'dimensions' => '120x60x75 cm',
                'price' => 3200000,
                'stock' => 7,
                'images' => json_encode(['products/meja-kerja-modern.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['lemari']->id,
                'name' => 'Lemari Pakaian Jati 3 Pintu',
                'slug' => 'lemari-pakaian-jati-3-pintu',
                'description' => 'Lemari pakaian megah 3 pintu dari kayu jati solid. Dilengkapi cermin, gantungan, dan rak penyimpanan. Ukiran halus khas Jepara di bagian pintu.',
                'dimensions' => '150x60x200 cm',
                'price' => 8500000,
                'stock' => 2,
                'images' => json_encode(['products/lemari-3-pintu.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['tempat-tidur']->id,
                'name' => 'Tempat Tidur Jati Queen Size',
                'slug' => 'tempat-tidur-jati-queen-size',
                'description' => 'Tempat tidur queen size (160x200 cm) dari kayu jati pilihan. Headboard ukir elegan, konstruksi kokoh, finishing doff premium.',
                'dimensions' => '160x200x120 cm',
                'price' => 7200000,
                'stock' => 4,
                'images' => json_encode(['products/tempat-tidur-queen.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['rak']->id,
                'name' => 'Rak Buku Jati 5 Tingkat',
                'slug' => 'rak-buku-jati-5-tingkat',
                'description' => 'Rak buku minimalis 5 tingkat dari kayu jati. Cocok untuk ruang baca, ruang keluarga, atau kantor. Kuat menahan beban buku berat.',
                'dimensions' => '80x30x180 cm',
                'price' => 2800000,
                'stock' => 6,
                'images' => json_encode(['products/rak-buku-5-tingkat.jpg']),
                'is_active' => true,
            ],
            [
                'category_id' => $catModels['aksesoris']->id,
                'name' => 'Pigura Cermin Jati Ukir',
                'slug' => 'pigura-cermin-jati-ukir',
                'description' => 'Pigura cermin dinding dengan bingkai kayu jati berukir motif floral Jepara. Menambah kesan mewah pada ruangan.',
                'dimensions' => '80x100 cm',
                'price' => 1500000,
                'stock' => 10,
                'images' => json_encode(['products/pigura-cermin-ukir.jpg']),
                'is_active' => true,
            ],
        ];

        $prodModels = [];
        foreach ($products as $product) {
            $prodModels[$product['slug']] = Product::create($product);
        }

        // === CUSTOM ORDERS ===
        $co1 = CustomOrder::create([
            'user_id' => $budi->id,
            'description' => 'Meja rapat kayu jati panjang 3 meter dengan 10 lubang kabel integrasi power outlet.',
            'dimensions' => '300x120x75 cm',
            'material' => 'Kayu Jati Solid TPK Perhutani',
            'finishing' => 'Natural Satin',
            'color' => 'Natural Wood',
            'status' => 'submitted',
            'created_at' => now()->subDays(2),
        ]);

        $co2 = CustomOrder::create([
            'user_id' => $citra->id,
            'description' => 'Dipan tempat tidur anak tingkat (bunk bed) dengan tangga berbentuk laci penyimpanan.',
            'dimensions' => '120x200 cm',
            'material' => 'Kayu Jati kombinasi Mahoni',
            'finishing' => 'Duco Matte',
            'color' => 'Putih Bersih & Pink Soft',
            'status' => 'under_review',
            'created_at' => now()->subDays(4),
        ]);

        $co3 = CustomOrder::create([
            'user_id' => $budi->id,
            'description' => 'Rak buku sekat ruangan minimalis industrial rangka besi.',
            'dimensions' => '180x40x200 cm',
            'material' => 'Kayu Jati & Frame Besi Hollow Hitam',
            'finishing' => 'Natural Doff',
            'color' => 'Coklat Gelap & Hitam',
            'admin_notes' => 'Desain disetujui, besi menggunakan hollow 4x4 tebal 1.2mm.',
            'agreed_price' => 4800000,
            'status' => 'approved',
            'created_at' => now()->subDays(6),
        ]);

        $co4 = CustomOrder::create([
            'user_id' => $citra->id,
            'description' => 'Kursi goyang santai lansia dengan sandaran anyaman rotan alami.',
            'dimensions' => '70x100x110 cm',
            'material' => 'Kayu Jati Solid Pilihan',
            'finishing' => 'Glossy natural',
            'color' => 'Natural Jati',
            'admin_notes' => 'Rotan alami kualitas ekspor.',
            'agreed_price' => 2500000,
            'status' => 'converted_to_order',
            'created_at' => now()->subDays(8),
        ]);

        // === ORDERS & PAYMENTS & PRODUCTION LOGS ===

        // Order 1: Custom Order Converted (Citra) - Paid & In Production
        $order1 = Order::create([
            'user_id' => $citra->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'custom',
            'status' => 'in_production',
            'total_amount' => 2500000,
            'shipping_address' => 'Jl. Dago No. 45, Bandung, Jawa Barat',
            'notes' => 'Custom Order Kursi Goyang Lansia',
            'created_at' => now()->subDays(8),
        ]);
        $co4->update(['order_id' => $order1->id]);

        Payment::create([
            'order_id' => $order1->id,
            'midtrans_transaction_id' => 'MID-CUST-' . uniqid(),
            'snap_token' => 'SNAP-CUST-' . uniqid(),
            'payment_type' => 'bank_transfer',
            'amount' => 2500000,
            'status' => 'paid',
            'paid_at' => now()->subDays(7),
            'raw_response' => json_encode(['status_code' => '200', 'transaction_status' => 'settlement']),
        ]);

        ProductionLog::create([
            'order_id' => $order1->id,
            'status' => 'order_received',
            'notes' => 'Pesanan kustom dikonfirmasi dan pembayaran telah diterima.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(7),
        ]);

        ProductionLog::create([
            'order_id' => $order1->id,
            'status' => 'material_preparation',
            'notes' => 'Pemilihan kayu jati solid tanpa cacat dan rotan penjalin.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(6),
        ]);

        ProductionLog::create([
            'order_id' => $order1->id,
            'status' => 'in_production',
            'notes' => 'Proses pemotongan rangka utama kursi goyang.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(4),
        ]);


        // Order 2: Regular Catalog Order (Budi) - Pending Payment
        $order2 = Order::create([
            'user_id' => $budi->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'regular',
            'status' => 'pending_payment',
            'total_amount' => 4500000,
            'shipping_address' => 'Jl. Pemuda No. 10, Semarang, Jawa Tengah',
            'notes' => 'Kirim di sore hari jika memungkinkan.',
            'created_at' => now()->subHours(5),
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $prodModels['kursi-tamu-jati-ukir-klasik']->id,
            'qty' => 1,
            'price' => 4500000,
            'subtotal' => 4500000,
        ]);

        Payment::create([
            'order_id' => $order2->id,
            'snap_token' => 'SNAP-REG-' . uniqid(),
            'amount' => 4500000,
            'status' => 'pending',
        ]);


        // Order 3: Regular Catalog Order (Andi Guest) - Paid & In Production
        $order3 = Order::create([
            'user_id' => $andi->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'regular',
            'status' => 'in_production',
            'total_amount' => 8200000,
            'shipping_address' => 'Jl. Malioboro No. 12, Yogyakarta',
            'guest_name' => 'Andi Guest',
            'guest_email' => 'andi@guest.com',
            'guest_phone' => '081234567893',
            'notes' => 'Akun tamu dibuat otomatis.',
            'created_at' => now()->subDays(3),
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $prodModels['kursi-makan-jati-minimalis']->id,
            'qty' => 2,
            'price' => 1200000,
            'subtotal' => 2400000,
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $prodModels['meja-makan-jati-6-kursi']->id,
            'qty' => 1,
            'price' => 5800000,
            'subtotal' => 5800000,
        ]);

        Payment::create([
            'order_id' => $order3->id,
            'midtrans_transaction_id' => 'MID-REG-' . uniqid(),
            'snap_token' => 'SNAP-REG-' . uniqid(),
            'payment_type' => 'credit_card',
            'amount' => 8200000,
            'status' => 'paid',
            'paid_at' => now()->subDays(3)->addHours(1),
            'raw_response' => json_encode(['status_code' => '200', 'transaction_status' => 'capture']),
        ]);

        ProductionLog::create([
            'order_id' => $order3->id,
            'status' => 'order_received',
            'notes' => 'Pesanan diterima. Pembayaran kartu kredit berhasil.',
            'updated_by' => $superadmin->id,
            'created_at' => now()->subDays(3)->addHours(1),
        ]);

        ProductionLog::create([
            'order_id' => $order3->id,
            'status' => 'material_preparation',
            'notes' => 'Persiapan kayu jati solid untuk meja makan dan kursi makan.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(2),
        ]);

        ProductionLog::create([
            'order_id' => $order3->id,
            'status' => 'in_production',
            'notes' => 'Pemotongan kayu dan perakitan rangka kursi makan.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDay(),
        ]);


        // Order 4: Regular Catalog Order (Citra) - Ready to Ship
        $order4 = Order::create([
            'user_id' => $citra->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'regular',
            'status' => 'ready_to_ship',
            'total_amount' => 3200000,
            'shipping_address' => 'Jl. Dago No. 45, Bandung, Jawa Barat',
            'created_at' => now()->subDays(5),
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'product_id' => $prodModels['meja-kerja-jati-modern']->id,
            'qty' => 1,
            'price' => 3200000,
            'subtotal' => 3200000,
        ]);

        Payment::create([
            'order_id' => $order4->id,
            'midtrans_transaction_id' => 'MID-REG-' . uniqid(),
            'snap_token' => 'SNAP-REG-' . uniqid(),
            'payment_type' => 'gopay',
            'amount' => 3200000,
            'status' => 'paid',
            'paid_at' => now()->subDays(5)->addMinutes(15),
            'raw_response' => json_encode(['status_code' => '200', 'transaction_status' => 'settlement']),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'order_received',
            'notes' => 'Pesanan diverifikasi.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(5)->addMinutes(15),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'material_preparation',
            'notes' => 'Kayu jati meja disiapkan.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(4),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'in_production',
            'notes' => 'Perakitan laci dan kaki meja.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(3),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'finishing',
            'notes' => 'Finishing melamine natural.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDays(2),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'quality_check',
            'notes' => 'Lolos uji kekuatan dan kestabilan kaki meja.',
            'updated_by' => $admin->id,
            'created_at' => now()->subDay(),
        ]);

        ProductionLog::create([
            'order_id' => $order4->id,
            'status' => 'ready_to_ship',
            'notes' => 'Barang sudah dibungkus bubble wrap tebal, menunggu armada logistik.',
            'updated_by' => $admin->id,
            'created_at' => now(),
        ]);


        // Order 5: Regular Catalog Order (Budi) - Completed
        $order5 = Order::create([
            'user_id' => $budi->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'regular',
            'status' => 'completed',
            'total_amount' => 1500000,
            'shipping_address' => 'Jl. Pemuda No. 10, Semarang, Jawa Tengah',
            'created_at' => now()->subDays(10),
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'product_id' => $prodModels['pigura-cermin-jati-ukir']->id,
            'qty' => 1,
            'price' => 1500000,
            'subtotal' => 1500000,
        ]);

        Payment::create([
            'order_id' => $order5->id,
            'midtrans_transaction_id' => 'MID-REG-' . uniqid(),
            'snap_token' => 'SNAP-REG-' . uniqid(),
            'payment_type' => 'bank_transfer',
            'amount' => 1500000,
            'status' => 'paid',
            'paid_at' => now()->subDays(10)->addHours(2),
            'raw_response' => json_encode(['status_code' => '200', 'transaction_status' => 'settlement']),
        ]);

        $logStatuses = ['order_received', 'material_preparation', 'in_production', 'finishing', 'quality_check', 'ready_to_ship', 'completed'];
        foreach ($logStatuses as $idx => $st) {
            ProductionLog::create([
                'order_id' => $order5->id,
                'status' => $st,
                'notes' => 'Tahapan ' . $st . ' selesai diproses.',
                'updated_by' => $superadmin->id,
                'created_at' => now()->subDays(10 - $idx),
            ]);
        }


        // Order 6: Regular Catalog Order (Andi Guest) - Cancelled
        $order6 = Order::create([
            'user_id' => $andi->id,
            'order_number' => Order::generateOrderNumber(),
            'type' => 'regular',
            'status' => 'cancelled',
            'total_amount' => 2800000,
            'shipping_address' => 'Jl. Malioboro No. 12, Yogyakarta',
            'guest_name' => 'Andi Guest',
            'guest_email' => 'andi@guest.com',
            'guest_phone' => '081234567893',
            'created_at' => now()->subDays(2),
        ]);

        OrderItem::create([
            'order_id' => $order6->id,
            'product_id' => $prodModels['rak-buku-jati-5-tingkat']->id,
            'qty' => 1,
            'price' => 2800000,
            'subtotal' => 2800000,
        ]);

        Payment::create([
            'order_id' => $order6->id,
            'snap_token' => 'SNAP-REG-' . uniqid(),
            'amount' => 2800000,
            'status' => 'expired',
        ]);
    }
}
