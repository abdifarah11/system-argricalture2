<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #f0f8ff;
        }
    </style>
</head>
<body>
    <h2>📊 Completed Reports</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Order Items</th>
                <th>Payment Method</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucfirst($t->user->fullname ?? '—') }}</td>
                    <td>
                        @if ($t->order && $t->order->items->count())
                            @foreach ($t->order->items as $item)
                                {{ ucfirst($item->crop->name ?? $item->name) }}<br>
                            @endforeach
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $t->paymentMethod->name ?? 'N/A' }}</td>
                    <td>${{ number_format($t->amount, 2) }}</td>
                    <td>{{ ucfirst($t->status) }}</td>
                    <td>{{ $t->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No completed transactions found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
