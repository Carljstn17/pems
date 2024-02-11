<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceRequest extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'text', 'entry_by'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'entry_by', 'id');
    }
}
