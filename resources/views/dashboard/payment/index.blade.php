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
    <div>
        <a href="{{ url('payment') }}">Pembyaran</a>
        <a href="{{ url('bill') }}">Tagihan</a>
        <a href="{{ url('transaksi') }}">Transaksi</a>
    </div>
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
</body>

</html>
