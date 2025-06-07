<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $data = [
            'balance' => $user->balance,
            'total_deposits' => $user->deposits()->where('status', 'paid')->sum('amount'),
            'total_orders' => $user->orders()->where('status', 'completed')->count(),
            'recent_deposits' => $user->deposits()->latest()->take(5)->get(),
            'recent_orders' => $user->orders()->with('items.product')->latest()->take(5)->get(),
        ];

        return view('dashboard.index', $data);
    }
}
