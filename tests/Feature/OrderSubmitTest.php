<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderSubmitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_valid_order_can_be_submitted_successfully()
    {
        // 1. Arrange
        $product = Product::factory()->create(['is_active' => true]);

        $orderData = [
            'product_id' => $product->id,
            'customer_name' => 'Test Customer',
            'phone' => '01001234567',
            'address' => '123 Test Street, Cairo',
        ];

        // 2. Act
        $response = $this->post(route('orders.store'), $orderData);

        // 3. Assert
        $response->assertRedirect(route('thanks'));

        $this->assertDatabaseHas('orders', [
            'product_id' => $product->id,
            'customer_name' => 'Test Customer',
            'phone' => '01001234567',
            'status' => 'new',
        ]);
    }

    /** @test */
    public function an_order_with_honeypot_field_is_rejected()
    {
        // 1. Arrange
        $product = Product::factory()->create(['is_active' => true]);

        $orderDataWithHoneypot = [
            'product_id' => $product->id,
            'customer_name' => 'Test Bot',
            'phone' => '01001234567',
            'address' => '123 Test Street, Cairo',
            'website' => 'i-am-a-bot', // Honeypot field filled
        ];

        // 2. Act
        $response = $this->post(route('orders.store'), $orderDataWithHoneypot);

        // 3. Assert
        $response->assertSessionHasErrors('website');
        $this->assertDatabaseMissing('orders', [
            'customer_name' => 'Test Bot',
        ]);
    }
}
