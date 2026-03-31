<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        // แยกหน้า Dashboard ตาม Role
        if ($role === 'admin') {
            return view('dashboards.admin');
        } elseif ($role === 'hr') {
            return view('dashboards.hr');
        } elseif ($role === 'inventory') {
            return view('dashboards.inventory');
        } else {
            return view('dashboards.employee');
        }
    }
}
