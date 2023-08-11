<?php

namespace App\Services\Midtrans;

use App\Models\Transaction;
use App\Services\Midtrans\Midtrans;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $order;
    protected $serverKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        // Transaction::where('transaction_id', "T23-0000022")->update([
        //     'status' => 51,
        //     'note' => $this->notification->signature_key,
        // ]);
        return ($this->_createLocalSignatureKey() == $this->notification->signature_key);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }

    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getOrder()
    {
        return $this->order;
    }

    protected function _createLocalSignatureKey()
    {
        $signature = hash(
            'sha512',
            $this->notification->order_id . $this->notification->status_code .
                $this->notification->gross_amount . $this->serverKey
        );
        // $orderId = $this->order->transaction_id;
        // $statusCode = $this->notification->status_code;
        // $grossAmount = $this->order->pay;
        // $serverKey = $this->serverKey;
        // $input = $orderId . $statusCode . $grossAmount . $serverKey;
        // $signature = openssl_digest($input, 'sha512');
        // Transaction::where('transaction_id', "T23-0000022")->update([
        //     'status' => 52,
        //     'channel' => $signature,
        // ]);
        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();
        $orderNumber = $notification->order_id;
        $order = Transaction::where('transaction_id', $orderNumber)->first();
        $this->notification = $notification;
        $this->order = $order;
    }
}