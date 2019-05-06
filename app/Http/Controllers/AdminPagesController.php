<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPagesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Route to go to  Admin Dashboard page
     *
     * @return View
     */
    public function dashboard()
    {
        return view('admin-pages.dashboard')->with(compact('admin_notifications'));
    }
}
