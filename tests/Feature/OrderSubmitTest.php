<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\Order;

class OrderSubmitTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_is_saved_successfully()
    {
        // use Arabic locale for the app during the test
        $this->app->setLocale('ar');

        $product = Product::create([
            'name' => 'منتج اختبار',
            'slug' => 'test-product',
            'description' => 'وصف',
            'price' => 100.00,
            'image_path' => '/images/placeholder.png',
            'category' => 'test',
            'is_active' => true,
        ]);

        $response = $this->post('/orders', [
            'product_id' => $product->id,
            'customer_name' => 'عميل اختبار',
            'phone' => '+201001234567',
            'address' => 'عنوان تجريبي 12',
            'email' => null,
            'notes' => null,
            // honeypot left empty
            'website' => '',
        ]);

        $response->assertRedirect('/thanks');

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'customer_name' => 'عميل اختبار',
            'phone' => '+201001234567',
            'status' => 'new',
        ]);
    }
}
