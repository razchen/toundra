<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThreeD;

class APIThreeDsController extends Controller
{
    public function index()
    {
        return response()->JSON(auth()->user()->three_ds);
    }

    public function create()
    {
 		return null;
    }

    public function edit(ThreeD $three_d, $model)
    {
    	return null;
    }

    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('view',$three_d);

 		return response()->JSON($three_d);
    }

    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('update',$three_d);

    	$attributes = $this->validateThreeD();

    	$three_d->update($attributes);

    	return response()->JSON($three_d);
    }

    public function store()
    {
    	$attributes = $this->validateThreeD();
    	$attributes['user_id'] = auth()->id();

 		$three_d = ThreeD::create($attributes);

 		return response()->JSON($three_d);
    }

    protected function validateThreeD()
    {
    	return request()->validate([
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
