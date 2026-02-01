<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'tool']);

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        // Statistics
        $stats = [
            'total_transactions' => $transactions->count(),
            'pending' => $transactions->where('status', 'pending')->count(),
            'approved' => $transactions->where('status', 'approved')->count(),
            'returned' => $transactions->where('status', 'returned')->count(),
            'rejected' => $transactions->where('status', 'rejected')->count(),
        ];

        return view('reports.index', compact('transactions', 'stats'));
    }

    public function print(Request $request)
    {
        $query = Transaction::with(['user', 'tool']);

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->where('borrow_date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('borrow_date', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->get();

        // Statistics
        $stats = [
            'total_transactions' => $transactions->count(),
            'pending' => $transactions->where('status', 'pending')->count(),
            'approved' => $transactions->where('status', 'approved')->count(),
            'returned' => $transactions->where('status', 'returned')->count(),
            'rejected' => $transactions->where('status', 'rejected')->count(),
        ];

        return view('reports.print', compact('transactions', 'stats'));
    }
}
