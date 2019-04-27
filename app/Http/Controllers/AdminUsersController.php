<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUsersController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
    }
    
    public function index()
    {
        // dd( User::orderBy('updated_at','desc')->get());
 		return view('admin-pages.users.index',[
 			'users' => User::orderBy('updated_at','desc')->get()
 		]);
    }

    public function show(User $user)
    {
 		return view('admin-pages.users.show')->with(compact('user'));
    }
    
}
