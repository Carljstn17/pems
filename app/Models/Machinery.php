<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Machinery extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'machinery_type',
        'machinery_name',
        'property',
        'unit_cost',
        'user_id',
    ];

    public function machineryReport()
    {
        return $this->hasOne(MachineryReport::class)->latest();
    }
}
