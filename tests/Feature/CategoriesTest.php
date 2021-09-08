<?php

namespace Tests\Feature;

use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_categories()
    {
        $status = ['status' => 'OK'];
        $categories = Categorie::factory(10)->create();

        $response = $this->get(route('categories.index'));

        $response->assertSee('categories');
        $response->assertJsonFragment($status);
        $response->assertJsonFragment($categories[0]->toArray());
    }

    public function test_get_categorie()
    {
        $status = ['status' => 'OK'];
        $categorie = Categorie::factory()->create();

        $this->get(
            route(
                'categories.show',
                ['category' => $categorie->id]
            )
        )
            ->assertJsonFragment($status)
            ->assertJsonFragment($categorie->toArray());
    }

    public function test_create_categories()
    {
        $post = ['name' => $this->faker->word()];

        $this->post(route('categories.store'), $post)
            ->assertJsonFragment(['status' => 'OK'])
            ->assertJsonFragment($post);

        $this->assertDatabaseHas('categories', $post);
    }

    public function test_delete_categorie()
    {
        $categorie = Categorie::factory()->create();

        $this->delete(
            route(
                'categories.destroy',
                [
                    'category' => $categorie
                ]
            )
        )
            ->assertJsonFragment(['status' => 'OK']);

        $this->assertDeleted('categories', $categorie->toArray());
    }

    public function test_update_categorie()
    {
        $categorie = Categorie::factory()->create();
        $updateData = ['name' => 'edited'];

        $this->patch(
            route(
                'categories.update',
                [
                    'category' => $categorie->id
                ]
            ),
            $updateData
        )
            ->assertJsonFragment(['status' => 'OK'])
            ->assertJsonFragment($updateData);

        $this->assertDeleted('categories', $categorie->toArray());
    }
}
