<?php

namespace Database\Seeders;

use App\Models\InstallmentPlan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstalmentPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    InstallmentPlan::create([
            'name' => 'خطة التقسيط الشهرية',
            'months_count'=>20,
            'interest_rate' => 30,
            
     
        ]);
    }
}
