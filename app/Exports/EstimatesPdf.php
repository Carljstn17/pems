<?php

namespace App\Exports;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Estimate;
use App\Models\User;

class EstimatesPdf
{
    protected $group_id;

    public function __construct($group_id)
    {
        $this->group_id = $group_id;
    }

    public function export()
    {
        $user = User::find(7);
        $estimates = Estimate::where('group_id', $this->group_id)->get();
        $pdf = new Dompdf();
        $pdf->loadHtml(view('export.pdf_estimate', compact('estimates','user'))->render());
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();
        return $pdf->stream('estimates.pdf');
    }
}
