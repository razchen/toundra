<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminUsersController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
    }
    
    public function index()
    {
 		return view('admin-pages.users.index',[
 			'users' => User::orderBy('updated_at','desc')->get()
 		]);
    }

    public function show(User $user)
    {
 		return view('admin-pages.users.show')->with(compact('user'));
    }

    public function create()
    {
 		return view('admin-pages.users.create');
    }

    public function edit(User $user)
    {
        return view('admin-pages.users.edit')->with(compact('user'));
    }

    public function update(User $user)
    {
        $attributes = $this->validateUser();

        $attributes['password'] = bcrypt($attributes['password']);
        
    	$user->update($attributes);

    	return redirect('/admin/users');
    }

    public function destroy(User $user)

    {

        $user->delete();

        return redirect()->route('users.index')->with('message','User deleted successfully');

    }


    public function store()
    {
        $attributes = $this->validateUser();
        
        $attributes['password'] = bcrypt($attributes['password']);

 		User::create($attributes);

 		return redirect('/admin/users');
    }

    protected function validateUser()
    {
    	return request()->validate([
    		'type' => 'sometimes|required',
    		'name' => 'required',
    		'email' => 'required|unique:users,email',
    		'api_key' => 'required|unique:users,api_key|min:4',
    		'password' => 'required|min:4',
    	]);
    }

    
}