<?php

namespace Database\Factories;

use App\Models\Come;
use App\Models\ProductCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Come::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $productCategory = ProductCategorie::factory()->create();
        return [
            'product_id' => $productCategory->product_id,
            'total' => 4,
            'unit_price' => 10000,
            'price' => 40000,
        ];
    }
}
