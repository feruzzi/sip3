    <a class="btn btn-sm btn-outline-danger delete-payment" data-id="{{ $payment->payment_id }}"><i
            class="icon dripicons dripicons-trash text-danger"></i></a>
    <a class="btn btn-sm btn-outline-warning mx-2 edit-payment" data-id="{{ $payment->payment_id }}"><i
            class="icon dripicons dripicons-document-edit text-warning"></i></a>
    @if ($payment->payment_status == 1)
        <button type="button" class="btn btn-sm btn-outline-danger set-payment" data-id="{{ $payment->payment_id }}"><i
                class="icon dripicons dripicons-wrong text-danger"></i></button>
    @elseif($payment->payment_status == 0)
        <button type="button" class="btn btn-sm btn-outline-success set-payment"
            data-id="{{ $payment->payment_id }}"><i
                class="icon dripicons dripicons-checkmark text-success"></i></button>
    @endif
