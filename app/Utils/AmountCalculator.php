<?php

// Create a new class, e.g., AmountCalculator.php

namespace App\Utils;

use App\Models\PayrollBatch;
use App\Models\Receipt;

class AmountCalculator
{
    /**
     * Calculate the total amount for each project_id.
     *
     * @return array
     */
    public static function calculateTotalAmountsReceiptByProject()
    {
        $receipts = Receipt::all();

        $totalAmountsReceiptByProject = [];

        foreach ($receipts as $receipt) {
            $project_id = $receipt->project_id;

            if (!isset($totalAmountsReceiptByProject[$project_id])) {
                $totalAmountsReceiptByProject[$project_id] = 0;
            }

            $totalAmountsReceiptByProject[$project_id] += $receipt->amount;
        }
        foreach ($totalAmountsReceiptByProject as &$total) {
            $total = round($total, 2);
        }

        return $totalAmountsReceiptByProject;
    }

    public static function calculateTotalAmountsPayrollByProject()
    {
        $payrolls = PayrollBatch::where('remarks', 'valid')->get();

        $totalAmountsPayrollByProject = [];

        foreach ($payrolls as $payroll) {
            $project_id = $payroll->project_id;

            if (!isset($totalAmountsPayrollByProject[$project_id])) {
                $totalAmountsPayrollByProject[$project_id] = 0;
            }

            $totalAmountsPayrollByProject[$project_id] += $payroll->total_salary;
        }
        foreach ($totalAmountsPayrollByProject as &$total) {
            $total = round($total, 2);
        }

        return $totalAmountsPayrollByProject;
    }
}
