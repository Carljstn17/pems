<?php

// Create a new class, e.g., AmountCalculator.php

namespace App\Utils;

use App\Models\Receipt;

class AmountCalculator
{
    /**
     * Calculate the total amount for each project_id.
     *
     * @return array
     */
    public static function calculateTotalAmountsByProject()
    {
        $receipts = Receipt::all();

        $totalAmountsByProject = [];

        foreach ($receipts as $receipt) {
            $project_id = $receipt->project_id;

            if (!isset($totalAmountsByProject[$project_id])) {
                $totalAmountsByProject[$project_id] = 0;
            }

            $totalAmountsByProject[$project_id] += $receipt->amount;
        }

        return $totalAmountsByProject;
    }
}
