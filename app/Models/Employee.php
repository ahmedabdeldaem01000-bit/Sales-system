<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // مهم لو الموظف بيسجل دخول
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role','phone','address'
    ];

    protected $hidden = ['password'];

    /**
     * الطلبات (المبيعات) التي نفذها الموظف
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'employee_id');
    }

// app/Models/Employee.php

public function orderItems()
{
    return $this->hasManyThrough(
        \App\Models\OrderItem::class, // الموديل النهائي اللي عايزين نوصل له
        \App\Models\Order::class,     // الجدول الوسيط
        'employee_id',                // المفتاح الخارجي في orders (اللي بيربط الموظف)
        'order_id',                   // المفتاح الخارجي في order_items (اللي بيربط order)
        'id',                         // المفتاح الأساسي في employees
        'id'                          // المفتاح الأساسي في orders
    );
}


  
    public function debts()
    {
        return $this->hasMany(Debtor::class, 'employee_id');
    }

    /**
     * المشتريات اللي الموظف عملها (لو بتستخدم جدول purchases)
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'employee_id');
    }

    /**
     * المنتجات اللي الموظف أضافها (لو فيه موظفين بيسجلوا منتجات)
     */
    // public function products()
    // {
    //     return $this->hasMany(Product::class, 'employee_id');
    // }
}
