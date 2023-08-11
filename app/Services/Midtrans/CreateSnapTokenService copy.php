<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;
    protected $pay;

    public function __construct($order, $pay)
    {
        parent::__construct();

        $this->order = $order;
        $this->pay = $pay;
    }

    public function getSnapToken()
    {
        dd(md5(now()));
        $params = [
            'transaction_details' => [
                'order_id' => md5(now()),
                'gross_amount' => $this->pay, //ganti
            ],
            'item_details' => [
                [
                    'id' => $this->order->bill_id,
                    'price' => $this->pay, //ganti
                    'quantity' => 1,
                    'name' => $this->order->bill_id,
                ],
            ],
            'customer_details' => [
                'first_name' => $this->order->username,
                'email' => 'mulyosyahidin95@gmail.com',
                'phone' => '081234567890',
            ]
        ];

        try {
            // Get Snap Payment Page URL
            $snapToken = Snap::getSnapToken($params);
            $paymentUrl = Snap::createTransaction($params)->redirect_url;

            // Redirect to Snap Payment Page
            header('Location: ' . $paymentUrl);
            return $snapToken;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
