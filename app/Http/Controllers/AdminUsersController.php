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
    
     /**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.users.index',[
 			'users' => User::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Display the specified User.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
 		return view('admin-pages.users.show')->with(compact('user'));
    }

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.users.create');
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin-pages.users.edit')->with(compact('user'));
    }

    /**
     * Update the specified User in storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $attributes = $this->validateUser($user->id);

        if( isset($attributes['password'])){
            $attributes['password'] = bcrypt($attributes['password']);
        }
        
    	$user->update($attributes);

    	return redirect('/admin/users');
    }

    /**
     * Remove the specified User from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users')->with('message','The user ' . $user->name . ' deleted successfully');
    }

    /**
     * Store a newly created User in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $attributes = $this->validateUser();
        $attributes["type"]=request()->type;
        $attributes["password"]=bcrypt(request()->password);

 		User::create($attributes);

 		return redirect('/admin/users');
    }

    /**
     * Validate the specified user.
     *
     * @return  \App\User  $user
     */
    protected function validateUser($user_id = false)
    {
        return request()->validate([
    		'name' => 'required',
            'email' => 'required|unique:users,email'.($user_id ? ','.$user_id : null),
    		'api_key' => 'required|min:4|unique:users,api_key'.($user_id ? ','.$user_id : null),
    	]);
    }

    
}