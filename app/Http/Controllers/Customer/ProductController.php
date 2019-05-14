<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    protected $_config;
    protected $product;

    public function __construct(Product $product)
    {
        $this->_config = request('_config');
        $this->product = $product;
    }

    public function index($id)
    {
        $product = $this->product->find($id);
        return view($this->_config['view'])->with([
            'product' => $product,
        ]);
    }
}
