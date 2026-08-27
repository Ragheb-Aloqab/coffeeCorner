<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrownCoffeeApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\BrownCoffeeSeeder::class);
    }

    public function test_can_fetch_categories_api(): void
    {
        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_can_fetch_products_api(): void
    {
        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_can_fetch_offers_api(): void
    {
        $response = $this->getJson('/api/v1/offers');

        $response->assertStatus(200)
            ->assertJsonPath('success', true);
    }

    public function test_can_fetch_settings_api(): void
    {
        $response = $this->getJson('/api/v1/settings');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.min_order_amount', 30);
    }

    public function test_order_creation_validates_minimum_amount(): void
    {
        $product = Product::first();

        // Order under 30 SAR
        $response = $this->postJson('/api/v1/orders', [
            'customer_name' => 'اختبار العميل',
            'customer_phone' => '0500000000',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1, // unit price ~12 SAR
                ],
            ],
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false);
    }

    public function test_can_create_order_successfully(): void
    {
        $product = Product::where('price', '>=', 15)->first();

        // Order 2 items >= 30 SAR
        $response = $this->postJson('/api/v1/orders', [
            'customer_name' => 'عميل اختبار',
            'customer_phone' => '0555555555',
            'delivery_address' => 'عنوان الاختبار',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                    'addon_matcha' => true,
                ],
            ],
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'data' => ['orderNumber', 'customerName', 'totalAmount', 'items'],
            ]);
    }

    public function test_admin_can_view_customers_list(): void
    {
        $admin = \App\Models\User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/customers');

        $response->assertStatus(200)
            ->assertSee('إدارة العملاء');
    }
}
