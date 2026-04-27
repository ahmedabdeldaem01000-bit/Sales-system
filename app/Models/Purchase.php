<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'supplier_id',
        'total_price',
        'quantity',
        'unit_price',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

 

    public function product()
    {
        return $this->belongsToMany(Product::class, 'purchase_items')
            ->withPivot('quantity', 'price');
    }
   
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
