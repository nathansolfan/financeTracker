<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'user_id',
        'source',
        'amount',
        'date',
    ];

    // INCOME belongsTo the MODEL USER::
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
