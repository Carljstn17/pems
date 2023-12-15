<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;

class ToolController extends Controller
{
    public function allTool(){
        $tools = Tool::all();

        return view("tool.all", compact('tools'));
    }
}
