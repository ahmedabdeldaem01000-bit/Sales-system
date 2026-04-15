<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
        use HasFactory;
 
    protected $fillable = ['employee_id'];

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

}
