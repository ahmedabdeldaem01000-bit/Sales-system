<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcessingSale extends Model
{
    protected $table = 'processing_sales';

    protected $fillable = [
        'product_name',
        'total_quantity_sold',
        'total_sales',
        'current_stock',
        'original_stock',
    ];
}
