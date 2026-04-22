<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InstallmentItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'installment_id',
        'due_date',
        'amount',
        'paid_amount',
        'status',
        'reminder_sent_at',
        'payment_link',
          'paypal_order_id',
          

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the installment this item belongs to.
     */
    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }

    /**
     * Get the payments for this installment item.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'installment_item_id');
    }

    /**
     * Get the remaining amount to be paid.
     */
    public function remainingAmount(): float
    {
        return (float) ($this->amount - $this->paid_amount);
    }

    /**
     * Check if payment is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'late' || 
               (now()->isAfter($this->due_date) && $this->status === 'pending');
    }

    /**
     * Mark as paid.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'paid_amount' => $this->amount,
            'status' => 'paid',
        ]);
    }
}
