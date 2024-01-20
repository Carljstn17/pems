<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'tool_id',
        'user_id',
        'whereabout',
    ];

    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function toolLog()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }
}
