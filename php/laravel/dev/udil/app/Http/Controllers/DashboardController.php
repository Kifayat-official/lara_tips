<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showDashboard()
    {
        $tests = \App\MdcTestSession::all();

        return view('dashboard', compact('tests'));
    }
}
