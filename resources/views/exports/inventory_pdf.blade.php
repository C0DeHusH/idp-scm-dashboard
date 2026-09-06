<!DOCTYPE html>
<html>
<head>
    <title>Inventory Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Warehouse Inventory Status</h2>
    <table>
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Description</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->description ?? 'N/A' }}</td>
                <td>{{ $record->quantity ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>