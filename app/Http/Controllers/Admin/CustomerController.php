<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    protected $_config;

    protected $customer;

    public function __construct()
    {
        $this->_config = request('_config');

        $this->middleware('admin');
    }

    public function index()
    {
        return view($this->_config['view']);
    }

    public function create()
    {
        return view($this->_config['view']);
    }

    public function store()
    {
        $this->validate(request(), [
            'channel_id' => 'required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'gender' => 'required',
            'email' => 'required|unique:customers,email',
            'date_of_birth' => 'date|before:today'
        ]);

        $data = request()->all();

        $password = bcrypt(rand(100000,10000000));

        $data['password'] = $password;

        $data['is_verified'] = 1;

        session()->flash('success', trans('admin.response.create-success', ['name' => 'Customer']));

        return redirect()->route($this->_config['redirect']);
    }

    public function edit($id)
    {
        return view($this->_config['view']);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'channel_id' => 'required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'gender' => 'required',
            'phone' => 'nullable|numeric|unique:customers,phone,'. $id,
            'email' => 'required|unique:customers,email,'. $id,
            'date_of_birth' => 'date|before:today'
        ]);

        session()->flash('success', trans('admin.response.update-success', ['name' => 'Customer']));

        return redirect()->route($this->_config['redirect']);
    }

    public function destroy($id)
    {
        session()->flash('success', trans('admin.response.delete-success', ['name' => 'Customer']));
        return redirect()->back();
    }
}
