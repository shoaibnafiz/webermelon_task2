<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Investment Tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
</head>

<body class="bg-gray-100">

    <div class="max-w-xl mx-2 sm:mx-auto py-8">
        <h1 class="text-2xl font-bold mb-4">Investment Tracker</h1>

        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST" class="bg-white p-6 rounded shadow-md mb-8">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-gray-700">Amount:</label>
                <input type="text" name="amount" id="amount" class="border border-gray-300 p-2 rounded w-full"
                    required>
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700">Type:</label>
                <select name="type" id="type" class="border border-gray-300 p-2 rounded w-full" required>
                    <option value="fund">Fund</option>
                    <option value="profit">Profit</option>
                    <option value="loss">Loss</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date:</label>
                <input type="date" name="date" id="date" class="border border-gray-300 p-2 rounded w-full"
                    required>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Add Transaction</button>
        </form>

        <div class="bg-white p-6 rounded shadow-md">
            <h2 class="text-xl font-bold mb-4">Generate Statement</h2>
            <form action="{{ route('transactions.statement', '') }}" method="GET" class="mb-4">
                <div class="mb-4">
                    <label for="month" class="block text-gray-700">Month:</label>
                    <input type="month" name="month" id="month"
                        class="border border-gray-300 p-2 rounded w-full" required>
                </div>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Generate</button>
            </form>
        </div>
    </div>
</body>

</html>
