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
                    'ar' => 'هاتف ذكي تجريبي',
                    'en' => 'Demo Smartphone'
                ],
                'slug' => 'smartphone-demo',
                'description' => [
                    'ar' => 'هاتف ذكي بمواصفات متوازنة ومناسب للاستخدام اليومي.',
                    'en' => 'Smartphone with balanced specifications suitable for daily use.'
                ],
                'price' => 1499.00,
                'image_path' => '/images/products/phone.png',
                'category' => [
                    'ar' => 'إلكترونيات',
                    'en' => 'electronics'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'سماعات لاسلكية',
                    'en' => 'Wireless Headphones'
                ],
                'slug' => 'wireless-headphones',
                'description' => [
                    'ar' => 'سماعات مريحة وصوت نقي مع إلغاء الضوضاء.',
                    'en' => 'Comfortable headphones with clear sound and noise cancellation.'
                ],
                'price' => 299.50,
                'image_path' => '/images/products/headphones.png',
                'category' => [
                    'ar' => 'صوتيات',
                    'en' => 'audio'
                ],
                'is_active' => true,
            ],
            [
                'name' => [
                    'ar' => 'ساعة ذكية',
                    'en' => 'Smart Watch'
                ],
                'slug' => 'smartwatch-demo',
                'description' => [
                    'ar' => 'ساعة ذكية لمتابعة النشاطات والصحة مع بطارية طويلة.',
                    'en' => 'Smart watch for tracking activities and health with long battery life.'
                ],
                'price' => 799.00,
                'image_path' => '/images/products/watch.png',
                'category' => [
                    'ar' => 'أجهزة قابلة للارتداء',
                    'en' => 'wearables'
                ],
                'is_active' => true,
            ],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
