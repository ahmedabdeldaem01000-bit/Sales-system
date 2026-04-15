<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model

{
        use HasFactory;
 
    protected $fillable = ['order_id','product_id','total' ,'quantity', 'price'];

    public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
protected $appends = ['total'];

public function getTotalAttribute()
{
    return $this->price * $this->quantity;
}
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id');
}

}
