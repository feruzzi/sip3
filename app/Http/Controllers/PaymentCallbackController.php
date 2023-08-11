<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;
        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            $payment_type = $notification->payment_type;
            $bank = "";
            $va = "";

            if ($notification->payment_type == 'credit_card') {
                $bank = $notification->bank;
            }
            if ($notification->payment_type == 'bank_transfer') {
                if (isset($notification->va_numbers[0])) {
                    $va = $notification->va_numbers[0]->va_number;
                    $bank = $notification->va_numbers[0]->bank;
                } else {
                    $bank = $notification->bank;
                }
            }

            $payment_type = strtoupper(str_replace("_", " ", $payment_type));
            $bank = strtoupper(str_replace("_", " ", $bank));
            $channel = $payment_type . "-" . $va . "-" . "(" . $bank . ")";

            if ($callback->isSuccess()) {
                Transaction::where('id', $order->id)->update([
                    'status' => 1,
                    'channel' => $channel,
                ]);
            }

            if ($callback->isExpire()) {
                Transaction::where('id', $order->id)->update([
                    'status' => 2,
                    'channel' => $channel,
                ]);
            }

            if ($callback->isCancelled()) {
                Transaction::where('id', $order->id)->update([
                    'status' => 3,
                    'channel' => $channel,
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notification successfully processed',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key not verified',
                ], 403);
        }
    }
}
