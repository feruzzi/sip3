<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;
    protected $pay;
    protected $email;
    protected $id;

    public function __construct($order, $pay, $email, $id)
    {
        parent::__construct();

        $this->order = $order;
        $this->pay = $pay;
        $this->email = $email;
        $this->id = $id;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->id,
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
                'email' => $this->email,
            ]
        ];
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}
