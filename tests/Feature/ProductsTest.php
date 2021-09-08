<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_products()
    {
        $status = ['status' => 'OK'];
        $products = Product::factory(10)->create();

        $response = $this->get(route('products.index'));

        $response->assertSee('products');
        $response->assertJsonFragment($status);
    }

    // public function test_get_category()
    // {
    //     $status = ['status' => 'OK'];
    //     $categorie = Product::factory()->create();

    //     $this->get(
    //         route(
    //             'categories.show',
    //             ['category' => $categorie->id]
    //         )
    //     )
    //         ->assertJsonFragment($status)
    //         ->assertJsonFragment($categorie->toArray());
    // }

    // public function test_create_category()
    // {
    //     $post = ['name' => $this->faker->word()];

    //     $this->post(route('categories.store'), $post)
    //         ->assertJsonFragment(['status' => 'OK'])
    //         ->assertJsonFragment($post);

    //     $this->assertDatabaseHas('categories', $post);
    // }

    // public function test_delete_categorie()
    // {
    //     $categorie = Product::factory()->create();

    //     $this->delete(
    //         route(
    //             'categories.destroy',
    //             [
    //                 'category' => $categorie
    //             ]
    //         )
    //     )
    //         ->assertJsonFragment(['status' => 'OK']);

    //     $this->assertDeleted('categories', $categorie->toArray());
    // }

    // public function test_update_categorie()
    // {
    //     $categorie = Product::factory()->create();
    //     $updateData = ['name' => 'edited'];

    //     $this->patch(
    //         route(
    //             'categories.update',
    //             [
    //                 'category' => $categorie->id
    //             ]
    //         ),
    //         $updateData
    //     )
    //         ->assertJsonFragment(['status' => 'OK'])
    //         ->assertJsonFragment($updateData);

    //     $this->assertDeleted('categories', $categorie->toArray());
    // }
}
