<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Facades\Cart;
use App\Facades\Payment;
use Illuminate\Support\Facades\DB;
use App\Models\Order as OrderRepository;
use App\Models\OrderItem as OrderItemRepository;

class OnepageController extends Controller
{
    protected $_config;
    protected $orderRepository;
    protected $orderItemRepository;

    public function __construct(OrderRepository $orderRepository, OrderItemRepository $orderItemRepository)
    {
        $this->_config = request('_config');
        $this->orderRepository = $orderRepository;
        $this->orderItemRepository = $orderItemRepository;
    }

    public function index()
    {
        //pending: 有待完善，需要检查cart
        return view($this->_config['view'])->with('cart', Cart::getCart());
    }

    public function saveOrder()
    {
        //pending: 有待完善，需要检查cart
        Cart::collectTotals();

        $cart = Cart::getCart();

        $request = request()->except('_token');
        $data = Cart::prepareDataForOrder();
        $data['shipping_method'] = $request['shipping_method'];
        $data['pay_method'] = $request['payment']['method'];
        $data['status'] = 'pending';

        //pending: 数字的处理有待改善，之后应该需要封装一个方法来处理
        //不需要单独处理。当前先实现功能，走通流程
        $data['grand_total'] = round($data['grand_total'],2);
        $data['base_grand_total'] = round($data['base_grand_total'],2);

        DB::beginTransaction();
        try {
            $order = $this->orderRepository->create($data);
            foreach ($data['items'] as $item) {
                if (isset($item['product']) && $item['product']) {
                    $item['product_id'] = $item['product']->id;
                    $item['product_type'] = get_class($item['product']);

                    unset($item['product']);
                }
                $orderItem = $this->orderItemRepository->create(array_merge($item, ['order_id' => $order->id]));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        Cart::deActivateCart();

        session()->flash('order', $order);
        //支付
        return Payment::payPage($order);
    }

    public function success(Request $request)
    {
        if (! $order = session('order'))
            //pending: 需要改善下单支付流程
            return redirect()->route('shop.home.index');

        //pending: 整个支付流程有待完善
        //支付成功就改成processing
        //支付失败就改成pending_payment
        //需要修改order状态,当前暂不做处理
        $data = Payment::returnPage($order);
        return view($this->_config['view'], compact('order'));
    }
}
