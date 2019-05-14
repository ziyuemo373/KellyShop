<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $_config;
    protected $category;

    public function __construct(Category $category)
    {
        $this->_config = request('_config');
        $this->category = $category;
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
            'slug' => 'required',
            'name' => 'required',
        ]);

        $category = $this->category->create(request()->all());
        session()->flash('success', trans('admin.response.create-success', ['name' => 'Category']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        if(strtolower($this->category->find($id)->name) == "root") {
            session()->flash('warning', trans('admin.response.delete-category-root', ['name' => 'Category']));
        } else {
            session()->flash('success', trans('admin.response.delete-success', ['name' => 'Category']));
            $c = $this->category->find($id);
            $c->delete();
        }

        return redirect()->back();
    }
}
