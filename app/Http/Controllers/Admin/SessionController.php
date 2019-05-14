<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SessionController extends Controller
{
    protected $_config;

    public function __construct()
    {
        $this->middleware('admin')->except(['create','store']);

        $this->_config = request('_config');

        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        } else {
            if (strpos(url()->previous(), 'admin') !== false) {
                $intendedUrl = url()->previous();
            } else {
                $intendedUrl = route('admin.dashboard.index');
            }

            session()->put('url.intended', $intendedUrl);

            return view($this->_config['view']);
        }
    }

    public function store()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember = request('remember');

        if (! auth()->guard('admin')->attempt(request(['email', 'password']), $remember)) {
            session()->flash('error', trans('app.users.users.login-error'));

            return redirect()->back();
        }

        if (auth()->guard('admin')->user()->status == 0) {
            session()->flash('warning', trans('app.users.users.activate-warning'));

            auth()->guard('admin')->logout();

            return redirect()->route('admin.session.index');
        }

        return redirect()->intended(route($this->_config['redirect']));
    }

    public function destroy($id)
    {
        auth()->guard('admin')->logout();

        return redirect()->route($this->_config['redirect']);
    }
}
