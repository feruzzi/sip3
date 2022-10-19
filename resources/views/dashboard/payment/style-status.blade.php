<span
    class="font-extrabold {{ $payment->payment_status == 1 ? 'badge bg-light-success' : 'badge bg-light-warning' }}">{{ $payment->payment_status == 1 ? 'Aktif' : 'Tidak Aktif' }}
</span>
