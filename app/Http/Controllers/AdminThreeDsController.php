<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThreeD;
use App\User;

class AdminThreeDsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    public function index()
    {
 		return view('admin-pages.three_ds.index',[
 			'three_ds' => ThreeD::orderBy('updated_at','desc')->get()
 		]);
    }

    public function create()
    {
 		return view('admin-pages.three_ds.create',[
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    public function edit(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
        $users = User::rderBy('name','asc')->get();
 		return view('admin-pages.three_ds.edit')->with(compact('three_d','users'));
    }

    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);

 		return view('admin-pages.three_ds.show')->with(compact('three_d'));
    }

    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);

    	$attributes = $this->validateThreeD();

    	$three_d->update($attributes);

    	return redirect('/admin/models');
    }

    public function store()
    {
    	$attributes = $this->validateThreeD();

 		ThreeD::create($attributes);

 		return redirect('/admin/models');
    }

    protected function validateThreeD()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
