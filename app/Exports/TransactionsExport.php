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
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->date)->format('Y-m-d');
            });

        $transactionsAsDate = [];
        foreach ($transactions as $date => $transactionGroup) {
            $transactionsAsDate[$date] = [
                'date' => $date,
                'fund' => $transactionGroup->where('type', 'fund')->sum('amount'),
                'profit' => $transactionGroup->where('type', 'profit')->sum('amount'),
                'loss' => $transactionGroup->where('type', 'loss')->sum('amount'),
            ];
        }

        return collect($transactionsAsDate);
    }

    public function headings(): array
    {
        return ['Amount', 'Total Investments', 'Total Profit', 'Total Loss'];
    }
}
