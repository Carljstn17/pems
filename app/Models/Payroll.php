<?php

namespace App\Models;

use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'project_id',
        'name',
        'rate_per_day',
        'no_of_days',
        'ot_rate',
        'ot_hour',
        'ot_amount',
        'salary',
        'advance_amount',
        'net_amount',
        'entry_by',
        'batch_id',
    ];

    protected $casts = [
        'name' => 'string', // or other type
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function entryBy()
    {
        return $this->belongsTo(User::class);
    }

    public function __get($propertyName) {
        switch ($propertyName) {
            case 'rate_per_day':
                $rate_per_day_default_value = 500;
                return !empty($this->rate_per_day) ? $this->rate_per_day : $rate_per_day_default_value;
            case 'ot_rate':
                $ot_rate_default_value = 1.25;
                return !empty($this->ot_rate) ? $this->ot_rate : $ot_rate_default_value;
            default:
                return null;
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'entry_by');
    }

    public function payrollBatch()
    {
        return $this->belongsTo(PayrollBatch::class, 'batch_id');
    }

}
