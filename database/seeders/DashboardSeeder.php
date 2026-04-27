<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ====== CREATE USERS (Customers) ======
        $users = User::factory(15)->create();

        // ====== CREATE PRODUCTS ======
        $products = Product::get();
        // ====== CREATE ORDERS WITH ITEMS (Distributed across months) ======
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        
        foreach($months as $month) {
            // 5-15 orders per month
            $ordersCount = rand(5, 15);
            
            for($i = 0; $i < $ordersCount; $i++) {
                $user = $users->random();
                $total = 0;
                
                $order = Order::create([
                    'user_id' => $user->id,
                    'employee_id' => 1, // Assuming employee_id 1 exists
                    'payment_type' => ['cache', 'paypal','installment'][rand(0, 2)],
                    'paid_amount' => 0,
                    'total' => 0,
                    'created_at' => Carbon::create(2026, $month, rand(1, 28), rand(9, 17)),
                    'updated_at' => now(),
                ]);

                // Add 2-5 items per order
                $itemsCount = rand(2, 5);
                for($j = 0; $j < $itemsCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 10);
                    $price = $product->price;
                    $itemTotal = $quantity * $price;
                    
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total' => $itemTotal,
                        'created_at' => $order->created_at,
                        'updated_at' => now(),
                    ]);
                    
                    $total += $itemTotal;
                }

                // Update order total
                $order->update([
                    'total' => $total,
                    'paid_amount' => rand(0, 1) == 0 ? $total : rand($total * 0.3, $total * 0.7),
                ]);
            }
        }

        $this->command->info('Dashboard seeder completed successfully!');
        $this->command->info('✓ ' . $users->count() . ' users created');
        $this->command->info('✓ ' . $products->count() . ' products created');
        $this->command->info('✓ Orders created with items across all months');
    }
}
