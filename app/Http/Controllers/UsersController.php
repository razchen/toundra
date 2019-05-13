<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
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
        if (request()->wantsJson()) {
            return response()->JSON(User::orderBy('updated_at','desc')->get());
        } else {
            return view('user-pages.users.reactive',[
                'users' => User::orderBy('updated_at','desc')->get()
            ]); 
        }
    }

    /**
     * Display the specified User.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (request()->wantsJson()) {
            return response()->JSON($user);
        } else {
            return view('user-pages.users.reactive')->with(compact('user'));   
        }
    }

    /**
     * Show the form for creating a new User.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.users.reactive');
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (request()->wantsJson())
            return null;

        return view('user-pages.users.reactive')->with(compact('user'));
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

        if( isset($attributes['password']) ){
            $attributes['password'] = bcrypt($attributes['password']);
        }
        
    	$user->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($user);
        } else {
            return redirect('/users');
        }
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

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/users')->with('message','The user ' . $user->name . ' deleted successfully');
        }
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

 		$user = User::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($user);
        } else {
            return redirect('/users');
        }
    }

    /**
     * Validate the specified user.
     *
     * @return \Illuminate\Http\Request  $request
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