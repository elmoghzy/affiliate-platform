<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => [
                    'en' => 'Demo Smartphone',
                    'ar' => 'هاتف ذكي تجريبي'
                ],
                'slug' => 'smartphone-demo',
                'description' => [
                    'en' => 'Smartphone with balanced specifications suitable for daily use.',
                    'ar' => 'هاتف ذكي بمواصفات متوازنة ومناسب للاستخدام اليومي.'
                ],
                'price' => 1499.00,
                'image_path' => 'products/phone.png',
                'category' => [
                    'en' => 'Electronics',
                    'ar' => 'إلكترونيات'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Wireless Headphones',
                    'ar' => 'سماعات لاسلكية'
                ],
                'slug' => 'wireless-headphones',
                'description' => [
                    'en' => 'Comfortable headphones with clear sound and noise cancellation.',
                    'ar' => 'سماعات مريحة وصوت نقي مع إلغاء الضوضاء.'
                ],
                'price' => 299.50,
                'image_path' => 'products/headphones.png',
                'category' => [
                    'en' => 'Audio',
                    'ar' => 'صوتيات'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'en' => 'Smart Watch',
                    'ar' => 'ساعة ذكية'
                ],
                'slug' => 'smartwatch-demo',
                'description' => [
                    'en' => 'Smart watch for tracking activities and health with long battery life.',
                    'ar' => 'ساعة ذكية لمتابعة النشاطات والصحة مع بطارية طويلة.'
                ],
                'price' => 799.00,
                'image_path' => 'products/watch.png',
                'category' => [
                    'en' => 'Wearables',
                    'ar' => 'أجهزة قابلة للارتداء'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
