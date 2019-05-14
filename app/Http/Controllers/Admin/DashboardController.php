<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    protected $_config;

    public function __construct()
    {
        $this->_config = request('_config');

        $this->middleware('admin');
    }

    public function index()
    {
        return view($this->_config['view']);
    }
}
