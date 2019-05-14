<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    protected $_config;

    public function __construct()
    {
        $this->middleware('customer')->except(['show','create']);
        $this->_config = request('_config');
    }

    public function show()
    {
        if (auth()->guard('customer')->check()) {
            return redirect()->route('customer.session.index');
        } else {
            return view($this->_config['view']);
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (! auth()->guard('customer')->attempt(request(['email', 'password']))) {
            session()->flash('error', trans('app.customer.login-form.invalid-creds'));

            return redirect()->back();
        }

        if (auth()->guard('customer')->user()->is_verified == 0) {
            session()->flash('info', trans('app.customer.login-form.verify-first'));

            Cookie::queue(Cookie::make('enable-resend', 'true', 1));

            Cookie::queue(Cookie::make('email-for-resend', $request->input('email'), 1));

            auth()->guard('customer')->logout();

            return redirect()->back();
        }
        return redirect()->intended(route($this->_config['redirect']));
    }

    public function destroy($id)
    {
        auth()->guard('customer')->logout();
        return redirect()->route($this->_config['redirect']);
    }
}
