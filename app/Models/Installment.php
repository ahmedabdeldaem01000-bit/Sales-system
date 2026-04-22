<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'plan_id',
        'total_with_interest',
        'down_payment',
        'remaining_amount',
        'start_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_with_interest' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'start_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


      /**
     * Get the installment items for this installment.
     */
    public function installment(): HasMany
    {
        return $this->hasMany(InstallmentItem::class, 'installment_id');
    }

    /**
     * Get the order this installment belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    
    /**
     * Get the installment plan for this installment.
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(InstallmentPlan::class, 'plan_id');
    }

  
    /**
     * Calculate the total paid amount across all items.
     */
    public function totalPaid(): float
    {
        return $this->items()->sum('paid_amount');
    }

    /**
     * Check if all items are paid.
     */
    public function isPaid(): bool
    {
        return $this->items()->count() > 0 && 
               $this->items()->where('status', '!=', 'paid')->count() === 0;
    }

    /**
     * Check if any item is overdue.
     */
    public function hasLatePayments(): bool
    {
        return $this->items()->where('status', 'late')->exists();
    }
}
