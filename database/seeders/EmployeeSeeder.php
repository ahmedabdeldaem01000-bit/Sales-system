<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'name' => 'اسلام',
            'phone' => '01012345678',
            'role'=>'employee',
            'email'=>'email1@email.com',
            'password' => bcrypt('00000000'),

 
        ]);
    
        Employee::create([
            'name' => 'خلاف',
            'phone' => '01098765432',
            'role'=>'employee',
            'email'=>'email2@email.com',

            'password' => bcrypt('11111111'),

     
        ]);
        Employee::create([
            'name' => 'admin',
            'phone' => '01098765432',
            'role'=>'admin',
            'email'=>'email0@email.com',
            'password' => bcrypt('password'),
        ]);
         User::create([
            'name' => 'ahmed',
            'email'=>'ahmedabdeldaem01000@gmail.com',
            'phone' => '011098765432',
            'address'=>"cairo",
            'role'=>'user',
     
        ]);
    }
}
