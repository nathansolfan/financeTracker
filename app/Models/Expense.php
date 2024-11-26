<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    protected $fillable = [
        'user_id',
        'amount',
        'category',
        'description',
        'date',
    ];

    // expense belongs to a specific USER
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
