    <span
        class="font-extrabold badge {{ $transaction->debit < 0 ? 'bg-light-danger' : 'bg-light-success' }}">{{ 'Rp ' . number_format($transaction->debit, 2, ',', '.') }}
    </span>
