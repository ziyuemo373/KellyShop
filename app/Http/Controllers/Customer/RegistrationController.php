<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;

class RegistrationController extends Controller
{

    protected $_config;
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->_config = request('_config');
        $this->customer = $customer;
    }

    public function show()
    {
        return view($this->_config['view']);
    }

    public function create(Request $request)
    {
        $request->validate([
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'email|required|unique:customers,email',
            'password' => 'confirmed|min:6|required',
        ]);

        $data = request()->input();
        $data['password'] = bcrypt($data['password']);
        $data['is_verified'] = 1;
        $verificationData['email'] = $data['email'];
        $verificationData['token'] = md5(uniqid(rand(), true));
        $data['token'] = $verificationData['token'];
        $customer = $this->customer->create($data);

        if ($customer) {
            try {
                session()->flash('success', trans('app.customer.signup-form.success'));
                //pending: 需要支持发送email
            } catch(\Exception $e) {
                session()->flash('info', trans('app.customer.signup-form.success-verify-email-not-sent'));

                return redirect()->route($this->_config['redirect']);
            }

            return redirect()->route($this->_config['redirect']);
        } else {
            session()->flash('error', trans('app.customer.signup-form.failed'));

            return redirect()->back();
        }
    }
}
