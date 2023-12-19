<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estimate extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $table = 'estimates';

    protected $fillable = [
        'group_id',
        'user_id',
        'description', 
        'uom', 
        'quantity', 
        'unit_cost', 
        'created_at',
        'updated_at',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmount() {
        return $this->quantity * $this->unit_cost;
    }

    public function totalAmount($estimates) {
        $totalAmount = 0;
        foreach ($estimates as $estimate) {
            $totalAmount += $estimate->getAmount();
        }
        return $totalAmount;
    }
}
