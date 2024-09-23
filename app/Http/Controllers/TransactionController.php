<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:fund,profit,loss',
            'date' => 'required|date',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction added successfully');
    }

    public function statement(Request $request)
    {
        $month = Carbon::createFromFormat('Y-m', $request->month);
        $year = $month->year;
        $monthNumber = $month->month;

        $transactions = Transaction::whereYear('date', $year)
            ->whereMonth('date', $monthNumber)
            ->get();

        $summary = [
            'fund' => $transactions->where('type', 'fund')->sum('amount'),
            'profit' => $transactions->where('type', 'profit')->sum('amount'),
            'loss' => $transactions->where('type', 'loss')->sum('amount'),
        ];

        return view('transactions.statement', compact('transactions', 'summary', 'month'));
    }

    public function export($month)
    {
        return Excel::download(new TransactionsExport($month), "transactions_{$month}.csv");
    }
}
