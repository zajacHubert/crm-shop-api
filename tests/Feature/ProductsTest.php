<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProductsTest extends TestCase
{
    public function test_get_all_products(): void
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_create_new_product(): void
    {

        $data = [
            'product_name' => 'New product name',
            'product_desc' => 'New test product description',
            'product_category' => 'regular',
            'product_price' => 110.55,
        ];

        $response = $this->post('/api/products', $data);

        $response->assertCreated();

        Product::where('product_name', 'New product name')->delete();
    }
}
