<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstimateTotal extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'total_amount'];

    public function estimate()
    {
        return $this->belongsTo(Estimate::class, 'group_id', 'group_id');
    }
}
