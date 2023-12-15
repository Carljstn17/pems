<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'user_id',
        'name', 
        'entry_by',
        'payroll_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entryBy()
    {
        return $this->belongsTo(User::class);
    }
}
