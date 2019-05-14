<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use Illuminate\Support\Facades\Redis;
use App\Models\Category;

class TestController extends Controller
{
    protected $config = [
        'alipay' => [
            'app_id' => '2016092900622176',
//            'notify_url' => '',
            'return_url' => '',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApzGaXL2YD/qNdRthkdnba+oNf+8xUhZFk9hjQe5ZgAP61TliiYYxIGyqwvN74ETZo37oXjMEyxHml44lum4mMQFKCTv2BcJPoW3XmhbIUJNb/O+vjEphQY/T2fYndEdk51pgdP4zsRp7mPCq0BXMgw0uFuOWwuRHzHEp9jfREWtPRA/w+7dKh6Loq8evaIofXhu1WPGL6NtqZIGaVHOJADAgWmzQ7aL76yR6oB22j2w0qtrWpa8zH4zCnddSCw3qsc178Npqb/lOfLO5KiYPrpgV8Sc82BmuX7nbl+VKermQvx4MYg1x1P+BP/8Nl3h4AthiZHzKEuSgDCoV2ipC3QIDAQAB',
            'private_key' => 'MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDg8R0gnS+B7anI7IG/1R+rsvykOMfOsk7Ip/PeeVUY7nWs21VpoJNTNa3rjf7v4NWrjd3nrtby1CSh0SsnU1b+qVKErnBfmPM5hmcNfUVcdgUiEGJVZaEk68SE4zGblxrbR/hpeYQ1h7if3zlnYcmx30GUiuiZKgT5PGpQVVISe5fRa9oV5DUf0FUzVTvRvbb52GYjKfq4pmahZBdHUpMg4f000oxiRwihd8m9/877vE2pkElFM2l+7MiySYqWXUSmPk9MMECnTJAeoPHFJBJXBceB/H4urYsq34Oxf10FsFyxZy9RYEA7lt7v4nMbFPRh/8N+d8/jQoYNn9WG6d+PAgMBAAECggEANjdnQdkg/jv+VENM8qO3wnadlidpYVRw0MRKbzDnZd7z1fn3mEHvwHqLtN7At6iFV5gWCCWIAXdIbQgxUoUvzqmZDgnNY/1FgnP2mrW65hI8In24dcTNFk0NTMpFxq6g9oFeSm3Tg+N2iHIRL+3N42VgNSFV9rS+BiSdq0clRPa5X4e6p/Foh41zJCts4bPZyJxeTU8ggdqXIhsN4w1JI//s5wupM0qfS5+afY53MCH2lesbA0em4Qn7u/SocRVOKVHM7NzqapKguMGuMD0Y9LZI14umgdm8n2ov8QmEae6E0HQwyqC1xA5cOnb/67ayzEnSokWhkwo1Hz2La38t4QKBgQD36q+SioFjjZUxZTw5bCvJLlSyjBOauqjQGYQy9r9WTJ57THT4tysVJyUx2hBMoQTjdNzjaB94vCy+65koPLpLuUr/JBY1MCmwNVkot1qzih5C76mQKDrBc+suu0uDOYxJ/yBlMu+pZKy1QCuLpPDLbrbbzoRcfrmBcqGsBBCM2wKBgQDoRqkvXpb/EFn0IZ4UygoPj+dsH8iNvmkN7hIRVcZRW7vgLqDc3+GAHXGtAUlYwik0ymw0CcPYPr/UyAtDuUrSDUysKstsABkITuO11Ydbh536uH+xEFzmvQCoy4XlzJyrtCPkhb+8bS454TCLflTvAwcPCRVK7hnF5QvcvVhcXQKBgE47r+X1cTlCL4dj4+pW+UZGKZIiY/la1/S7aJ1QgjawfP55tRvbaWwGa1Vc8/HKiilg8meMrwnBj/k7jZxF9Z/5u/HhqGRma3FglF8l5Shs+Hm0+XQ1Tb1IYDnh/sVNPrkHGmj09u4kh9+2fUdW6Gm56VhZxikOEGoKC3yl17crAoGBALhTmt9kiR9QspHyO6jzzJgc8uHzNwyFFolfbCclkoPt8GIvnqipYiJxO0y3wKUXL+wc11FUjn6FDWameYn8+UtIEphuPZAvY64cLMiX8xrHvK7Cy1KQUakqQ+Ov30pF3e7EvdcT7NxzKEP2WLfaQTyLgoaEBsm3uew5n/hEqmJhAoGAEuSjyZo4L9A3b67yu78vcjwxSgkoWPZQjIVRpvO4m2JINvFe6xcUJdnAKvZUuzsLfHZ9OPU7Xl7NB5ztbYN9z01EAtPIJREOcTt2xC+417FidblMoyZ5y4MG7eYpPMnhAWMKr0Mx7tzAcdskJOGso5cTY+UdRiCdFscNRh0kFLc=',
            'log' => [ // optional
                'file' => './logs/alipay.log',
                'level' => 'debug', // 建议生产环境等级调整为 info，开发环境为 debug
                'type' => 'daily', // optional, 可选 daily.
                'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
            ],
            'http' => [ // optional
                'timeout' => 5.0,
                'connect_timeout' => 5.0,
                // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
            ],
             'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        ],
    ];

    public function __construct()
    {
//        $this->config['alipay']['notify_url'] = route('test.notify');
        $this->config['alipay']['return_url'] = route('test.return');
    }

    public function index()
    {
//        $id = 1;
//        $tree = Redis::get('category:tree:'.$id);
//        $tree = \Opis\Closure\unserialize($tree);
//        var_dump($tree);
//
//        $treeCollection = Category::orderBy('position', 'ASC')->where('id', '!=', $id)->get()->toTree();
//        var_dump($treeCollection);

//        $tree = serialize($treeCollection);
//        Redis::set('category:tree:'.$id, $tree);



//        $order = [
//            'out_trade_no' => '1006',
//            'total_amount' => '0.1',
//            'subject' => 'test subject',
//        ];
//
//        $alipay = Pay::alipay($this->config['alipay'])->web($order);
//
//        return $alipay;// laravel 框架中请直接 `return $alipay`
    }

    public function return(Request $request)
    {
//        file_put_contents('/mnt/hgfs/code/kellyshop/storage/logs/test.log',print_r('alipay return',1),FILE_APPEND);
        $alipay = Pay::alipay($this->config['alipay']);
        $data = $alipay->verify();
        return $data;
    }

    public function notify(Request $request)
    {
//        file_put_contents('/mnt/hgfs/code/kellyshop/storage/logs/test.log',print_r('alipay notify',1),FILE_APPEND);
        $alipay = Pay::alipay($this->config['alipay']);

        if ($alipay->verify($request->all())) {
//            file_put_contents('/mnt/hgfs/code/kellyshop/storage/logs/test.log',print_r($request->all(),1),FILE_APPEND);
//            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
//            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
//            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
//            file_put_contents('/mnt/hgfs/code/kellyshop/storage/logs/test.log',"收到异步通知\r\n".print_r($request->all(),1),FILE_APPEND);
//            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}
