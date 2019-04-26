<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\User;
use DB;

class AdminCamerasController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    public function index()
    {
 		return view('admin-pages.cameras.index',[
 			'cameras' => Camera::orderBy('updated_at','desc')->get()
 		]);


    }

    public function create()
    {
 		return view('admin-pages.cameras.create',[
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    public function edit(Camera $camera)
    {
        $users = User::orderBy('name','asc')->get();
 		return view('admin-pages.cameras.edit')->with(compact('camera','users'));
    }

    public function show(Camera $camera)
    {
 		return view('admin-pages.cameras.show')->with(compact('camera'));
    }

    public function update(Camera $camera)
    {
    	$attributes = $this->validateCamera();

    	$camera->update($attributes);

    	return redirect('/admin/cameras');
    }

    public function store()
    {
    	$attributes = $this->validateCamera();

 		Camera::create($attributes);

 		return redirect('/admin/cameras');
    }

    protected function validateCamera()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'intrinsic' => 'required|max:5',
    	]);
    }
}
