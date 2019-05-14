<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    protected $_config;
    protected $category;
    protected $product;

    public function __construct(Category $category, Product $product)
    {
        $this->_config = request('_config');
        $this->category = $category;
        $this->product = $product;
    }

    public function index()
    {
        $tree = Redis::get('category:home:tree');
        if(empty($tree)){
            $tree = $this->category->getCategoryTree(1);
            Redis::set('category:home:tree', serialize($tree));
        } else {
            $tree = unserialize($tree);
        }

        //pending: 只需要拿最新的product，暂时简单处理
        $products = Redis::get('product:home:all');
        if(empty($products)){
            $products = $this->product->get();
            Redis::set('product:home:all', serialize($products));
        } else {
            $products = unserialize($products);
        }

        return view($this->_config['view'])->with([
            'categories' => $tree,
            'products' => $products,
        ]);
    }
}
