<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    use HasFactory;

    protected $fillable = ['group_id','user_id','description', 'uom', 'quantity', 'unit_cost', 'amount'];
}
