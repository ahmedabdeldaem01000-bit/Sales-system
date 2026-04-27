<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;
    // السماح بالإدخال الجماعي
    protected $fillable = [
        'purchase_id', 
        'product_id', 
        'quantity', 
        'unit_price', 
        'total_price'
    ];

 
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}