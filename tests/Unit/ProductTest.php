<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Product;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    public function test_can_create_product() {
        $data = [
            'name' => $this->faker->sentence,
            'quantity' => $this->faker->number,
            'description' => $this->faker->sentence,
        ];
        $this->post(route('api/products.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }
    public function test_can_update_product() {
        $product = factory(Product::class)->create();
        $data = [
            'name' => $this->faker->sentence,
            'quantity' => $this->faker->number,
            'description' => $this->faker->sentence
        ];
        $this->put(route('api/products.update', $product->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }
    public function test_can_show_product() {
        $product = factory(Product::class)->create();
        $this->get(route('api/products.show', $product->id))
            ->assertStatus(200);
    }
    public function test_can_delete_product() {
        $product = factory(Product::class)->create();
        $this->delete(route('api/products.delete', $product->id))
            ->assertStatus(204);
    }
    public function test_can_list_products() {
        $products = factory(Product::class, 2)->create()->map(function ($product) {
            return $product->only(['id', 'name', 'quantity', 'description']);
        });
        $this->get(route('products'))
            ->assertStatus(200)
            ->assertJson($products->toArray())
            ->assertJsonStructure([
                '*' => [ 'id', 'name', 'quantity', 'description' ],
            ]);
    }
}
