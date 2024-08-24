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
        'name',
        'email',
        'phone',
        'address',
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

}