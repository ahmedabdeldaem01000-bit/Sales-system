<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        use HasFactory;
 
    protected $fillable = ['employee_id','user_id','total','payment_type','paid_amount','paypal_order_id','month'];

    public function items()
{
    return $this->hasMany(OrderItem::class);
}
public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function employee()
{
    return $this->belongsTo(Employee::class);
}

public function user()
{
 
    return $this->belongsTo(User::class, 'user_id');
}

public function installments()
{
    return $this->hasMany(Installment::class);
}

public function payments()
{
    return $this->hasMany(Payment::class);
}

}
