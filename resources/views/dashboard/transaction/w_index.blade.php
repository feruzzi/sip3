<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Transaksi</h1>
    <h1>Tabel Tagihan</h1>
    <table>
        <thead>
            <th>Username</th>
            <th>nama</th>
            <th>angkatan</th>
            <th>kelas</th>
            <th>Kekurangan</th>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->username }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->group1 }}</td>
                    <td>{{ $transaction->group2 }}</td>
                    <td>{{ $transaction->debit }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
