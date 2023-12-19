<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateDelete extends Model
{
    use HasFactory;

    protected $table = 'estimate_deletes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'group_id',
        'user_id',
        // Add other fillable fields if needed
    ];
}
