<?php

namespace App\Http;

use Yansongda\Pay\Pay;

class Payment
{

    protected $config;

    public function __construct()
    {
        $this->config = config('payment');
    }

    public function payPage($order)
    {
        $order_data = [
            'out_trade_no' => $order->id,   //pending: 有待改善
            'total_amount' => $order->grand_total,   //pending: 有待改善
            'subject' => 'test subject',   //pending: 有待改善
        ];
        $config = $this->config[$order->pay_method];
        $config['return_url'] = route('shop.checkout.success');   //pending: 有待改善
        $config['log']['file'] = storage_path('logs/alipay.log');
        $alipay = Pay::alipay($config)->web($order_data);   //pending: 有待改善，应该根据pay method选择调用的方法
        return $alipay;
    }

    public function returnPage($order)
    {
        $config = $this->config[$order->pay_method];
        $config['log']['file'] = storage_path('logs/alipay.log');
        $alipay = Pay::alipay($config);   //pending: 有待改善，应该根据pay method选择调用的方法
        $data = $alipay->verify();
        return $data;
    }
}