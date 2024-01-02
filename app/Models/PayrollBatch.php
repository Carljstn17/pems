<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'total_salary',
        'total_advance',
        'total_net',
        'ot_rate',
        'entry_by',
    ];
}
