<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_date',
        'project_id',
        'user_id',
        'si_or_no',
        'supplier_id',
        'description',
        'amount',
        'receipt_photo',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}
