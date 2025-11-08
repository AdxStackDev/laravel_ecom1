<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tag;
use Laravel\Sanctum\Sanctum;
use Silber\Bouncer\BouncerFacade as Bouncer;

class ProductApiTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create();
        Bouncer::assign('admin')->to($admin);
        Sanctum::actingAs($admin);

        $category = Category::factory()->create();
        $tags = Tag::factory()->count(3)->create();

        $productData = [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'price' => 99.99,
            'stock' => 10,
            'tag_ids' => $tags->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/v1/products', $productData);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'price']);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_seller_can_create_product()
    {
        $seller = User::factory()->create();
        Bouncer::assign('seller')->to($seller);
        Sanctum::actingAs($seller);

        $category = Category::factory()->create();
        $tags = Tag::factory()->count(3)->create();

        $productData = [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'price' => 99.99,
            'stock' => 10,
            'tag_ids' => $tags->pluck('id')->toArray(),
        ];

        $response = $this->postJson('/api/v1/products', $productData);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'name', 'price']);

        $this->assertDatabaseHas('products', ['name' => 'Test Product']);
    }

    public function test_viewer_cannot_create_product()
    {
        $viewer = User::factory()->create();
        Bouncer::assign('viewer')->to($viewer);
        Sanctum::actingAs($viewer);

        $category = Category::factory()->create();

        $productData = [
            'name' => 'Test Product',
            'category_id' => $category->id,
            'price' => 99.99,
            'stock' => 10,
        ];

        $response = $this->postJson('/api/v1/products', $productData);

        $response->assertStatus(403);
    }
}
