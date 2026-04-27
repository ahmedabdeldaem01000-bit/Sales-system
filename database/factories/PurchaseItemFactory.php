<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PurchaseItem>
 */
class PurchaseItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $Purchase=Purchase::inRandomOrder()->first() ?? Purchase::factory()->create();
        $product=Product::inRandomOrder()->first() ?? Product::factory()->create();
       $quantity= $product->quantity;
         $unit_price=$Purchase->total_price / $quantity;
        return [
            'purchase_id'=>$Purchase->id,
            'product_id'=>$product->id,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'total_price' => $quantity * $unit_price,
        ];
    }
}
