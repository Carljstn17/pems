<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\CompanyAttribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanyAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::find(1);

        if ($user) {
            CompanyAttribute::create([
                'ot_rate' => 1.25,
                'entry_by' => $user->id,
            ]);
        }
    }
}
