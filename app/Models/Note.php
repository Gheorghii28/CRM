<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * These attributes can be filled through mass assignment, such as during the creation or updating of a model instance.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',         
        'customer_id',    
        'deal_id',        
        'note_content',   
        'created_at',     
        'updated_at',     
    ];
    
    /**
     * Get the user that owns the note.
     * This defines a relationship where a note belongs to a specific user, typically the author or creator of the note.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the customer that the note is associated with.
     * This defines a relationship where a note may belong to a specific customer. This relationship is optional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    /**
     * Get the deal that the note is associated with.
     * This defines a relationship where a note may belong to a specific deal. This relationship is optional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }

}
