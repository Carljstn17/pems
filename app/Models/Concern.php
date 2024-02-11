<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Concern extends Model
{
    use Notifiable;
    use HasFactory;

    protected $fillable = ['concern', 'entry_by'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'entry_by', 'id');
    }
}
