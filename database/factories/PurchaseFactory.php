<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $supplier = Supplier::inRandomOrder()->first() ?? Supplier::factory()->create();//1
        $employee = Employee::inRandomOrder()->first() ?? Employee::factory()->create();//1

        $quantity = $this->faker->numberBetween(1, 100); //50
        $unit_price = $this->faker->randomFloat(2, 10, 500);//100.00
        $total_price = $quantity * $unit_price;//5000.00
        /**
         * PurchaseItemFactory
         */
      

        return [
            'supplier_id' => $supplier->id,
            'employee_id' => $employee->id,
            'total_price' => $total_price,
      
        ];
    
    }
}
