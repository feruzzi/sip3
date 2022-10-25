<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/main/app.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>

    <title>Sistem Informasi Pembayaran </title>
    <script>
        $(document).on("click", ".btn-print", function(e) {
            $('.btn-print').addClass('d-none')
            window.print()
            $('.btn-print').removeClass('d-none')
        });
    </script>
</head>

<body>

    <div class="print-area">
        <div class="text-center">
            <h3>Rincian Tagihan</h3>
            <h3>Sistem Informasi Pembayaran</h3>
        </div>
        <table class="table table-bordered mb-0">
            <thead>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Pembayaran</th>
                <th>Total Tagihan</th>
                <th>Dibayar</th>
                <th>Total</th>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaction->username }}</td>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->payment_name }}</td>
                        <td>{{ 'Rp ' . number_format($transaction->bill_amount, 2, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($transaction->pay, 2, ',', '.') }}</td>
                        <td>{{ 'Rp ' . number_format($transaction->debit, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="m-3 d-block">
        <button class="btn btn-secondary w-100 btn-print" onclick="printed()">Print</button>
    </div>
</body>

</html>
