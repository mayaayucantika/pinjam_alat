<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tools' => Tool::count(),
            'total_users' => User::where('role', 'peminjam')->count(),
            'borrowed_tools' => Transaction::whereIn('status', ['pending', 'approved'])->sum('quantity'),
            'pending_transactions' => Transaction::where('status', 'pending')->count(),
        ];

        $recent_transactions = Transaction::with(['user', 'tool'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.index', compact('stats', 'recent_transactions'));
    }
}
