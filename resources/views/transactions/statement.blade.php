@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Statement - {{ $month }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Investment Statement - {{ $month }}</h1>

        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold">Funds</h2>
                <p class="text-2xl">{{ $summary['fund'] }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold">Profits</h2>
                <p class="text-2xl">{{ $summary['profit'] }}</p>
            </div>
            <div class="bg-white p-6 rounded shadow-md">
                <h2 class="text-xl font-bold">Losses</h2>
                <p class="text-2xl">{{ $summary['loss'] }}</p>
            </div>
        </div>

        <table class="min-w-full bg-white shadow-md rounded">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200 border border-black">Date</th>
                    <th class="py-2 px-4 bg-gray-200 border border-black">Type</th>
                    <th class="py-2 px-4 bg-gray-200 border border-black">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td class="py-2 px-4 border border-black">
                            {{ Carbon::parse($transaction->date)->format('d M, Y') }}</td>
                        <td class="py-2 px-4 border border-black">{{ ucfirst($transaction->type) }}</td>
                        <td class="py-2 px-4 border border-black">{{ $transaction->amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-8">
            <a href="{{ route('transactions.export', $month) }}" class="bg-green-500 text-white p-2 rounded">Export to
                CSV</a>
        </div>
    </div>
</body>

</html>
