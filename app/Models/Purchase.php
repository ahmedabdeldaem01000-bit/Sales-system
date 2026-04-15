<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [

        'supplier_id',
        'product_id',
        'total_price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'purchase_items')
            ->withPivot('quantity', 'price');
    }
    // في Purchase.php
    // تحديد العلاقة مع الموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
