<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Facades\Cart;
use App\Models\CartItem as CartItemRepository;

class CartController extends Controller
{
    protected $_config;

    protected $cart;

    protected $cartItem;

    protected $customer;

    protected $product;

    public function __construct(CartItemRepository $cartItem)
    {
        $this->cartItem = $cartItem;
        $this->_config = request('_config');
    }

    public function index()
    {
        return view($this->_config['view'])->with('cart', Cart::getCart());
    }

    public function add($id)
    {
        try {
            $result = Cart::add($id, request()->except('_token'));
            Cart::collectTotals();

            if ($result) {
                session()->flash('success', trans('shop.checkout.cart.item.success'));

                return redirect()->route($this->_config['redirect']);
            } else {
                session()->flash('warning', trans('shop.checkout.cart.item.error-add'));

                return redirect()->back();
            }

            return redirect()->route($this->_config['redirect']);

        } catch(\Exception $e) {
            session()->flash('error', trans($e->getMessage()));

            return redirect()->back();
        }
    }

    public function remove($itemId)
    {
        Cart::removeItem($itemId);
        Cart::collectTotals();
        return redirect()->back();
    }

    public function updateBeforeCheckout()
    {
        $request = request()->except('_token');

        foreach ($request['qty'] as $id => $quantity) {
            if ($quantity <= 0) {
                session()->flash('warning', trans('shop.checkout.cart.quantity.illegal'));

                return redirect()->back();
            }
        }

        foreach ($request['qty'] as $key => $value) {
            $item = $this->cartItem->find($key);

            $data['quantity'] = $value;

            Cart::updateItem($item->product_id, $data, $key);

            unset($item);
            unset($data);
        }

        Cart::collectTotals();

        return redirect()->back();
    }
}
