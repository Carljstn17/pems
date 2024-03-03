<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;

class PayrollBatch extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'project_id',
        'total_salary',
        'total_advance',
        'total_net',
        'ot_rate',
        'entry_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function entry()
    {
        return $this->belongsTo(User::class, 'entry_by');
    }
}
