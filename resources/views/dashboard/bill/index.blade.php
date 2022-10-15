<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div>
        <a href="{{ url('payment') }}">Pembyaran</a>
        <a href="{{ url('bill') }}">Tagihan</a>
        <a href="{{ url('transaction') }}">Transaksi</a>
    </div>
    <h1>Tagihan Berkelompok</h1>
    <form action="{{ url('bill/mass_add') }}">
        @csrf
        <input type="text" name="group1" placeholder="group 1">
        <input type="text" name="group2" placeholder="group 2">
        {{-- <input type="text" name="payment" placeholder="payment"> --}}
        <select name="payment" id="payment">
            @foreach ($payments as $payment)
                <option value="{{ $payment->payment_id }}">{{ $payment->payment_name }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>
    <hr>
    <h1>Tabel Tagihan</h1>
    <table>
        <thead>
            <th>Username</th>
            <th>Name</th>
            <th>Tagihan</th>
        </thead>
        <tbody>
            @foreach ($bills as $bill)
                <tr>
                    <td>{{ $bill->username }}</td>
                    <td>{{ $bill->name }}</td>
                    <td>{{ $bill->tagihan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
