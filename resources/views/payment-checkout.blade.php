@extends('layouts.main.main')
@section('table_title', 'Pembayaran')
@section('content_title', 'Pembayaran')
@section('content')
    @push('footer-js')
        <script src="{{ asset('assets/extensions\autonumeric\autoNumeric.js') }}"></script>
        <script src="{{ asset('assets/js/currency_converter.js') }}"></script>
    @endpush
    <section class="section">
        <div class="row" id="table-hover-row">
            <div class="d-flex justify-content-center">
                <div class="card p-5">
                    <div class="card-header">
                        <h4 class="card-title">Pembayaran</h4>
                    </div>
                    <div class="card-content">
                        <div class="col-sm-12">
                            <label>
                                ID Tagihan
                            </label>
                            <input type="text" class="form-control" value="{{ $bills[0]->bill_id }}" disabled>
                        </div>
                        <div class="col-sm-12">
                            <label>
                                Nama Tagihan
                            </label>
                            <input type="text" class="form-control" value="{{ $bills[0]->payment_name }}" disabled>
                        </div>
                        <div class="col-sm-12">
                            <label>
                                Kekurangan
                            </label>
                            <br>
                            <span
                                class="font-extrabold badge {{ $bills[0]->debit < 0 ? 'bg-light-danger' : 'bg-light-success' }}">{{ 'Rp ' . number_format($bills[0]->debit, 2, ',', '.') }}
                            </span>
                        </div>
                        <form action="{{ url('pay-checkout/' . $bills[0]->bill_id) }}" method="post">
                            @csrf
                            <div class="col-sm-12">
                                <label>
                                    Email
                                </label>
                                <input type="email" class="form-control round amount_format" name="email"
                                    id="email">
                            </div>
                            <div class="col-sm-12">
                                <label>
                                    Bayar
                                </label>
                                <input type="text" class="form-control round amount_format" name="pay"
                                    id="pay">
                            </div>
                            <div class="col-sm-12">
                                <label>
                                    Keterangan
                                </label>
                                <textarea class="form-control" name="note" id="note" cols="30" rows="10"></textarea>
                            </div>
                            <div class="mt-3 d-flex">
                                <button class="btn btn-primary w-100">Bayar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
