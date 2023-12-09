<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'project_dsc',
        'client',
        'contract',
        'location',
        'date_started',
        'contact',
        'status'
    ];
}
