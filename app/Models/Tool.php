<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tool extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tool_type',
        'tool_name',
        'property',
        'quantity',
        'unit_cost',
        'user_id',
    ];

    public function toolReport()
    {
        return $this->hasOne(ToolReport::class)->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
