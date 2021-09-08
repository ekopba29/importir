<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\ProductCategorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComeTest extends TestCase
{
    use RefreshDatabase;
    public function test_insert_comes()
    {
        // $this->withoutExceptionHandling();
        $product = ProductCategorie::factory()->create();
        $post = [
            'product_id' => $product->product->id,
            'total' => 30,
            'unit_price' => 20000,
            'date_come' => now()->format('Y-m-d H:i')
        ];

        $data = $this->post(route('comes.store', $post))->getData();
        $this->assertDatabaseHas('comes', $post);
        $this->assertTrue($product->fresh()->product->total > 30);

        $this->post(route('comes.store', $post));
        $this->assertTrue($product->fresh()->product->total > 60);
    }

    public function test_update_comes()
    {
        $this->withoutExceptionHandling();
        $product = ProductCategorie::factory()->create();
        $post = [
            'product_id' => $product->product->id,
            'total' => 30,
            'unit_price' => 20000,
            'date_come' => now()->format('Y-m-d H:i')
        ];

        $come = $this->post(route('comes.store', $post))->getData();

        $idCome = $come->data->come[0]->id;

        $update = [
            'total' => 300,
            'unit_price' => 20000,
            'date_come' => now()->format('Y-m-d H:i')
        ];

        $patching = $this->patch(route('comes.update',['come' => $idCome]),$update)->getContent();

        dd($patching);
        $this->assertEquals($patching,$update);
        // $this->assertDatabaseHas('comes', $post);
        // $this->assertTrue($product->fresh()->product->total > 30);

        // $this->post(route('comes.store',$post));
        // $this->assertTrue($product->fresh()->product->total > 60);
    }
}
