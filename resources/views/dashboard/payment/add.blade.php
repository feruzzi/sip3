<!DOCTYPE html>
<html lang="en">
@php
// dd($bills);
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Tambah Pembayaran</h1>
    <form action="{{ url('payment/add') }}">
        @csrf
        <input type="text" name="payment_id" id="payment_id" placeholder="id pembayaran">
        <input type="text" name="payment_name" id="payment_name" placeholder="nama pembayaran">
        <input type="text" name="payment_amount" id="payment_amount" placeholder="Nominal Pembayaran">
        <input type="text" name="payment_status" id="payment_status" placeholder="Status">
        <button type="submit">Submit</button>
    </form>
    <hr>
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
