<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function showStaffReceipt()
    {
        return view('staff.receipt');
    }
}
