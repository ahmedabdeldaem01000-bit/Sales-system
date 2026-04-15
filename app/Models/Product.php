<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = ['name', 'description','barcode','sold_quantity', 'total_cost','quantity', 'price', 'cost_price','total', 'current_quantity'];

   
   public function purchase() {
    return $this->belongsToMany(Purchase::class, 'purchase_items');
}
}
