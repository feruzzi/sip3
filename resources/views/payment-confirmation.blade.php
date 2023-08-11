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
                        <h4 class="card-title">Konfirmasi Pembayaran</h4>
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
                        {{-- <form action="{{ url('pay-checkout/' . $bills[0]->bill_id) }}" method="get"> --}}
                        {{-- @csrf --}}
                        <div class="col-sm-12">
                            <label>
                                Bayar
                            </label>
                            <span
                                class="font-extrabold badge {{ $res->pay < 0 ? 'bg-light-success' : 'bg-light-success' }}">{{ 'Rp ' . number_format($res->pay, 2, ',', '.') }}
                            </span>
                        </div>
                        <div class="mt-3 d-flex">
                            <span>{{ $res->snap_token }}</span>
                            <span>{{ $res->pay }}</span>
                            <button class="btn btn-primary w-100" id="pay">Bayar Sekarang</button>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();

            snap.pay('{{ $res->snap_token }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                }
            });
        });
    </script>
@endsection
