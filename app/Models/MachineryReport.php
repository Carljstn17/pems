<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineryReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'machinery_id',
        'whereabout',
        'user_id'
    ];

    public function machinery()
    {
        return $this->belongsTo(Machinery::class);
    }
}

