<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        // Redirect to role-specific dashboard
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'hr':
                return redirect()->route('hr.dashboard');
            case 'inventory':
                return redirect()->route('inventory.dashboard');
            case 'manager':
                return redirect()->route('manager.dashboard');
            case 'employee':
                return redirect()->route('employee.dashboard');
            default:
                return view('dashboard');
        }
    }
}
