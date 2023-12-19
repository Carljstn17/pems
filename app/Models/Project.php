<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    use Searchable;

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
