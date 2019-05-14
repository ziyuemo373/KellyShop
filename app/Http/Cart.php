<?php

namespace App\Http;

use App\Models\Cart as CartRepository;
use App\Models\CartItem as CartItemRepository;
use App\Models\Product as ProductRepository;

class Cart
{
    protected $cart;
    protected $cartItem;
    protected $product;

    public function __construct(CartRepository $cart, CartItemRepository $cartItem, ProductRepository $product)
    {
        $this->cart = $cart;
        $this->cartItem = $cartItem;
        $this->product = $product;
    }

    public function create($id, $data, $qty = 1)
    {
        $cartData = [
            'items_count' => 1
        ];

        //Authentication details
        if (auth()->guard('customer')->check()) {
            $cartData['customer_id'] = auth()->guard('customer')->user()->id;
            $cartData['is_guest'] = 0;
            $cartData['customer_first_name'] = auth()->guard('customer')->user()->first_name;
            $cartData['customer_last_name'] = auth()->guard('customer')->user()->last_name;
            $cartData['customer_email'] = auth()->guard('customer')->user()->email;
        } else {
            $cartData['is_guest'] = 1;
        }

        $result = $this->cart->create($cartData);

        $this->putCart($result);

        if ($result) {
            if ($item = $this->createItem($id, $data))
                return $item;
            else
                return false;
        } else {
            session()->flash('error', trans('shop::app.checkout.cart.create-error'));
        }
    }

    public function add($id, $data) {
        $cart = $this->getCart();

        if ($cart != null) {
            $ifExists = $this->checkIfItemExists($id, $data);

            if ($ifExists) {
                $item = $this->cartItem->find($ifExists);

                $data['quantity'] = $data['quantity'] + $item->quantity;

                $result = $this->updateItem($id, $data, $ifExists);
            } else {
                $result = $this->createItem($id, $data);
            }

            return $result;
        } else {
            return $this->create($id, $data);
        }
    }

    public function checkIfItemExists($id, $data) {
        $items = $this->getCart()->items;
        foreach ($items as $item) {
            if ($id == $item->product_id) {
                $product = $this->product->find($id);
                return $item->id;
            }
        }

        return 0;
    }

    public function createItem($id, $data)
    {
        $product = $this->product->find($id);
        $canAdd = $product->haveSufficientQuantity($data['quantity']);
        if (! $canAdd) {
            session()->flash('warning', trans('shop.checkout.cart.quantity.inventory_warning'));
            return false;
        }

        //Check if the product's information is proper or not
        if (! isset($data['product']) || !isset($data['quantity'])) {
            session()->flash('error', trans('shop.checkout.cart.integrity.missing_fields'));
            return false;
        }

        //pending: 需要改善
        $price = $product->price;
        //pending: 需要改善
        $weight = 0;
        $parentData = [
            'sku' => $product->sku,
            'quantity' => $data['quantity'],
            'cart_id' => $this->getCart()->id,
            'name' => $product->text,
            //pending: 需要改善
            'price' => $price,
            'base_price' => $price,
            //pending: 需要改善
            'total' => bcmul($price , $data['quantity']),
            'base_total' => bcmul($price , $data['quantity']),
            'weight' => $weight,
            'total_weight' => $weight * $data['quantity'],
            'base_total_weight' => $weight * $data['quantity'],
            'type' => $product['type'],
            'product_id' => $product['id'],
        ];

        $result = $this->cartItem->create($parentData);
        return $result;
    }

    public function updateItem($id, $data, $itemId)
    {
        $item = $this->cartItem->find($itemId);

        if (isset($data['product'])) {
            $additional = $data;
        } else {
            $additional = $item->additional;
        }
        $product = $this->product->find($item->product_id);

        if (! $product->haveSufficientQuantity($data['quantity'])) {
            session()->flash('warning', trans('shop::app.checkout.cart.quantity.inventory_warning'));

            return false;
        }
        $quantity = $data['quantity'];

        $result = $item->update([
            'quantity' => $quantity,
            'total' => bcmul($item->price , ($quantity)),
            'base_total' => bcmul($item->price , ($quantity)),
            'total_weight' => $item->weight * ($quantity),
            'base_total_weight' => $item->weight * ($quantity),
        ]);

        $this->collectTotals();

        if ($result) {
            session()->flash('success', trans('shop.checkout.cart.quantity.success'));

            return $item;
        } else {
            session()->flash('warning', trans('shop.checkout.cart.quantity.error'));

            return false;
        }
    }

    public function removeItem($itemId)
    {
        if ($cart = $this->getCart()) {
            $this->cartItem->destroy($itemId);

            //delete the cart instance if no items are there
            if ($cart->items()->get()->count() == 0) {
                $this->cart->destroy($cart->id);

                if (session()->has('cart')) {
                    session()->forget('cart');
                }
            }
            session()->flash('success', trans('shop.checkout.cart.item.success-remove'));

            return true;
        }

        return false;
    }

    public function collectTotals()
    {
        $validated = $this->validateItems();

        if (! $validated) {
            return false;
        }

        if (! $cart = $this->getCart())
            return false;

        $cart->grand_total = $cart->base_grand_total = 0;
        $cart->sub_total = $cart->base_sub_total = 0;
        $cart->tax_total = $cart->base_tax_total = 0;

        foreach ($cart->items()->get() as $item) {
            $cart->grand_total = bcadd(bcadd($cart->grand_total , $item->total), $item->tax_amount);
            $cart->base_grand_total = bcadd(bcadd($cart->base_grand_total, $item->base_total), $item->base_tax_amount);

            $cart->sub_total = bcadd($cart->sub_total, $item->total);
            $cart->base_sub_total = bcadd($cart->base_sub_total, $item->base_total);

            $cart->tax_total = bcadd($cart->tax_total, $item->tax_amount);
            $cart->base_tax_total = bcadd($cart->base_tax_total, $item->base_tax_amount);
        }

        if ($shipping = $cart->selected_shipping_rate) {
            $cart->grand_total = bcadd($cart->grand_total, $shipping->price);
            $cart->base_grand_total = bcadd($cart->base_grand_total, $shipping->base_price);
        }

        $quantities = 0;
        foreach ($cart->items as $item) {
            $quantities = $quantities + $item->quantity;
        }

        $cart->items_count = $cart->items->count();

        $cart->items_qty = $quantities;

        $cart->save();
    }

    public function validateItems()
    {
        $cart = $this->getCart();

        if (! $cart) {
            return false;
        }

        //rare case of accident-->used when there are no items.
        if (count($cart->items) == 0) {
            $this->cart->delete($cart->id);

            return false;
        } else {
            $items = $cart->items;

            foreach ($items as $item) {
                if ($item->product->type == 'simple') {
                    if ($item->product->sku != $item->sku) {
                        $item->update(['sku' => $item->product->sku]);

                    } else if ($item->product->name != $item->name) {
                        $item->update(['name' => $item->product->name]);

                    }
                }
            }
            return true;
        }
    }

    public function deActivateCart()
    {
        if ($cart = $this->getCart()) {
            $cart->update(['is_active' => false]);

            if (session()->has('cart')) {
                session()->forget('cart');
            }
        }
    }

    public function saveShippingMethod($shippingMethodCode)
    {
        if (! $cart = $this->getCart())
            return false;

        $cart->shipping_method = $shippingMethodCode;
        $cart->save();

        return true;
    }

    public function prepareDataForOrder()
    {
        $data = $this->toArray();

        $finalData = [
            'customer_id' => $data['customer_id'],
            'is_guest' => $data['is_guest'],
            'customer_email' => $data['customer_email'],
            'customer_first_name' => $data['customer_first_name'],
            'customer_last_name' => $data['customer_last_name'],
            'customer' => auth()->guard('customer')->check() ? auth()->guard('customer')->user() : null,
            'total_item_count' => $data['items_count'],
            'total_qty_ordered' => $data['items_qty'],
            'grand_total' => $data['grand_total'],
            'base_grand_total' => $data['base_grand_total'],
        ];

        foreach ($data['items'] as $item) {
            $finalData['items'][] = $this->prepareDataForOrderItem($item);
        }

        return $finalData;
    }

    public function prepareDataForOrderItem($data)
    {
        $finalData = [
            'product' => $this->product->find($data['product_id']),
            'sku' => $data['sku'],
            'type' => $data['type'],
            'name' => $data['name'],
            'weight' => $data['weight'],
            'total_weight' => $data['total_weight'],
            'qty_ordered' => $data['quantity'],
            'price' => $data['price'],
            'base_price' => $data['base_price'],
            'total' => $data['total'],
            'base_total' => $data['base_total'],
        ];
        return $finalData;
    }

    public function toArray()
    {
        $cart = $this->getCart();

        $data = $cart->toArray();

        return $data;
    }

    public function getCart()
    {
        $cart = null;

        if (auth()->guard('customer')->check()) {
            $cart = $this->cart->where([
                'customer_id' => auth()->guard('customer')->user()->id,
                'is_active' => 1
            ])->first();

        } elseif (session()->has('cart')) {
            $cart = $this->cart->find(session()->get('cart')->id);
        }
        return $cart && $cart->is_active ? $cart : null;
    }

    public function putCart($cart)
    {
        if (! auth()->guard('customer')->check()) {
            session()->put('cart', $cart);
        }
    }
}