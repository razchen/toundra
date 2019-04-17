<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThreeD;

class ThreeDsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
 		return view('three_ds.index',[
 			'three_ds' => auth()->user()->three_ds
 		]);
    }

    public function create()
    {
 		return view('three_ds.create');
    }

    public function edit(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
 		return view('three_ds.edit')->with(compact('three_d'));
    }

    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('view',$three_d);

 		return view('three_ds.show')->with(compact('three_d'));
    }

    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('update',$three_d);

    	$attributes = $this->validateThreeD();

    	$three_d->update($attributes);

    	return redirect('/models');
    }

    public function store()
    {
    	$attributes = $this->validateThreeD();
    	$attributes['user_id'] = auth()->id();

 		ThreeD::create($attributes);

 		return redirect('/models');
    }

    protected function validateThreeD()
    {
    	return request()->validate([
    		'name' => 'required',
    		'point_of_view' => 'required|json',
    	]);
    }
}
