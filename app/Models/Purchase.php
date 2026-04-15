<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'supplier_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    // في Purchase.php
    // تحديد العلاقة مع الموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
