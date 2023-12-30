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
        'no_of_day',
        'ot_rate',
        'ot_hour',
        'ot_amount',
        'salary',
        'advance_amount',
        'net_amount',
        'total_amount'

    ];

    // public function __get($rate_per_day) {
    //     if(!empty($this->rate_per_day)){
    //         return $this->rate_per_day;
    //     }
    // return 500;     
    // }

    private $rate_per_day = 500;
    private $ot_rate = 1.25;

    public function __get($payroll) {
        switch ($payroll) {
            case 'rate_per_day':
                return !empty($this->rate_per_day) ? $this->rate_per_day : 500;
            case 'ot_rate':
                return !empty($this->ot_rate) ? $this->ot_rate : 1.25;
            default:
                // Handle unknown property access here, if needed
                return null;
        }
    }

}
