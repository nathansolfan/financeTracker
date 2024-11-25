<!DOCTYPE html>
<html>
<head>
    <title>Expenses</title>
</head>
<body>
    <h1>Your Expenses</h1>
    <table border="1">
        <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Description</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
                <tr>
                    <td>{{ $expense->id }}</td>
                    <td>{{ $expense->amount }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $expenses->links() }}
</body>
</html>
