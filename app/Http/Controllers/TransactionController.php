<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
use App\Models\Tool;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->isAdmin() || auth()->user()->isPetugas()) {
            $transactions = Transaction::with(['user', 'tool'])
                ->latest()
                ->paginate(15);
        } else {
            $transactions = Transaction::where('user_id', auth()->id())
                ->with('tool')
                ->latest()
                ->paginate(15);
        }

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        if (auth()->user()->isAdmin()) {
            abort(403);
        }

        $tools = Tool::where('stock', '>', 0)->get();
        return view('transactions.create', compact('tools'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->isAdmin()) {
            abort(403);
        }

        if (!auth()->user()->isActive()) {
            return back()->withErrors(['error' => 'Akun Anda tidak aktif.']);
        }

        $validated = $request->validate([
            'tool_id' => ['required', 'exists:tools,id'],
            'borrow_date' => ['required', 'date', 'after_or_equal:today'],
            'return_date' => ['required', 'date', 'after:borrow_date'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string'],
        ]);

        $tool = Tool::findOrFail($validated['tool_id']);

        if ($tool->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi.'])->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $transaction = Transaction::create($validated);
        ActivityLogger::logAction('create', 'Mengajukan peminjaman: ' . $tool->name . ' (Jumlah: ' . $transaction->quantity . ')', $transaction);

        return redirect()->route('transactions.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    public function show(Transaction $transaction)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isPetugas() && $transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['user', 'tool']);
        return view('transactions.show', compact('transaction'));
    }

    public function approve(Transaction $transaction)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['error' => 'Transaksi tidak dapat disetujui.']);
        }

        $tool = $transaction->tool;

        if ($tool->stock < $transaction->quantity) {
            return back()->withErrors(['error' => 'Stok tidak mencukupi.']);
        }

        $transaction->update(['status' => 'approved']);
        $tool->decrement('stock', $transaction->quantity);
        
        ActivityLogger::logAction('approve', 'Menyetujui peminjaman: ' . $tool->name . ' oleh ' . $transaction->user->name, $transaction);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject(Transaction $transaction)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isPetugas()) {
            abort(403);
        }

        if ($transaction->status !== 'pending') {
            return back()->withErrors(['error' => 'Transaksi tidak dapat ditolak.']);
        }

        $transaction->update(['status' => 'rejected']);
        
        ActivityLogger::logAction('reject', 'Menolak peminjaman: ' . $transaction->tool->name . ' oleh ' . $transaction->user->name, $transaction);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function return(Transaction $transaction)
    {
        if ($transaction->status !== 'approved') {
            return back()->withErrors(['error' => 'Transaksi tidak dapat dikembalikan.']);
        }

        if (!auth()->user()->isAdmin() && $transaction->user_id !== auth()->id()) {
            abort(403);
        }

        $transaction->update([
            'status' => 'returned',
            'actual_return_date' => now(),
        ]);

        $tool = $transaction->tool;
        $tool->increment('stock', $transaction->quantity);
        
        ActivityLogger::logAction('return', 'Mengembalikan alat: ' . $tool->name . ' oleh ' . $transaction->user->name, $transaction);

        return back()->with('success', 'Alat berhasil dikembalikan.');
    }
}
