<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
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
        return view($this->_config['view']);
    }

    public function create()
    {
        $categories = $this->category->getCategoryTree();
        return view($this->_config['view'], compact('categories'));
    }

    public function store()
    {
        $this->validate(request(), [
            'type' => 'required',
            'text' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'category_id' => 'required',
        ]);

        $product = $this->product->create(request()->all());
        $product->categories()->sync(request()->all()['category_id']);
        session()->flash('success', trans('admin.response.create-success', ['name' => 'Product']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        $p = $this->product->find($id);
        $p->delete();

        session()->flash('success', trans('admin.response.delete-success', ['name' => 'Product']));

        return redirect()->back();
    }
}
