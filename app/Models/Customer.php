<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'city',
        'stateprovince',
        'streetaddress',
        'zip',
        'country',
    ];
    
    /**
     * The attributes that should be cast to date.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    /**
     * Defines the relationship between the customer and contacts.
     * A customer can have many contacts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Defines the relationship between the customer and activities.
     * A customer can have many activities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Defines the relationship between the customer and deals.
     * A customer can have many deals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    /**
     * Defines the relationship between the customer and invoices.
     * A customer can have many invoices.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Defines the relationship between the customer and payments.
     * A customer can have many payments.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Defines the relationship between the customer and notes.
     * A customer can have many notes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    /**
     * Defines the relationship between the customer and transactions.
     * A customer can have many transactions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculates the total value of all deals for this customer.
     * Returns the sum of the 'deal_value' fields.
     *
     * @return float
     */
    public function totalDealValue()
    {
        return $this->deals()->sum('deal_value');
    }

    /**
     * Calculates the outstanding balance for this customer.
     * Returns the sum of the 'total_amount' fields for unpaid or overdue invoices.
     *
     * @return float
     */
    public function outstandingBalance()
    {
        return $this->invoices()->where('status', 'unpaid')
            ->orWhere('status', 'overdue')
            ->sum('total_amount');
    }

}
