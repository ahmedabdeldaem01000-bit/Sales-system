<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description','barcode','sold_quantity', 'total_cost','quantity', 'price', 'cost_price','total',    'current_quantity','supplier_id'];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}
}
