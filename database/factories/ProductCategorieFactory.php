<?php

namespace Database\Factories;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\ProductCategorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategorieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategorie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory()->create()->id,
            'categorie_id' => Categorie::factory()->create()->id
        ];
    }
}
