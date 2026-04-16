<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debtor extends Model
{
    use HasFactory;
    
//                                                                                   
    protected $fillable = ['name', 'price', 'quantity', 'employee_id', 'date' ,'payment_status'];
  
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
