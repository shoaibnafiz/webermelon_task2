<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function collection()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->month);
        $year = $date->year;
        $monthNumber = $date->month;

        $transactions = Transaction::whereYear('date', $year)
            ->whereMonth('date', $monthNumber)
            ->get(['amount', 'type', 'date']);

        $formattedTransactions = $transactions->map(function ($transaction) {
            return [
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'date' => Carbon::parse($transaction->date)->format('d M, Y'),
            ];
        });

        return collect($formattedTransactions);
    }

    public function headings(): array
    {
        return ['Amount', 'Type', 'Date'];
    }
}
