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

   
    public function orders()
    {
        return $this->hasMany(Order::class, 'employee_id');
    }



public function orderItems()
{
    return $this->hasManyThrough(
        OrderItem::class, 
        Order::class,     
        'employee_id',                
        'order_id',                   
        'id',                         
        'id'                          
    );
}


  
    public function debts()
    {
        return $this->hasMany(Debtor::class, 'employee_id');
    }

  
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'employee_id');
    }

 
}
