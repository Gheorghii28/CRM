<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
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
        'deal_id',
        'title',
        'task_description',
        'due_date',
        'status',
        'order',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that owns the task.
     * This defines a relationship where a task belongs to a specific user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deal that the task is associated with.
     * This defines a relationship where a task belongs to a specific deal. This relationship is optional.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class);
    }
}
