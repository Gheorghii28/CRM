<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'transaction_type',
        'transaction_date',
        'amount',
        'description',
    ];

    /**
     * Get the customer associated with the transaction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope a query to only include payments.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePayments($query)
    {
        return $query->where('transaction_type', 'payment');
    }

    /**
     * Scope a query to only include refunds.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRefunds($query)
    {
        return $query->where('transaction_type', 'refund');
    }

    /**
     * Scope a query to only include chargebacks.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeChargebacks($query)
    {
        return $query->where('transaction_type', 'chargeback');
    }
}
