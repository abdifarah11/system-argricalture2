<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Price History Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">📄 Price History Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Crop</th>
                <th>Region</th>
                <th>Quantity</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->crop->name ?? '—' }}</td>
                    <td>{{ $item->region->name ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ strtoupper($item->unit) }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
