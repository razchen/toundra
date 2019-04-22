<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;

class APICamerasController extends Controller
{

    public function index()
    {
        return response()->JSON(auth()->user()->cameras);	
    }

    public function create()
    {
 		return null;
    }

    public function edit()
    {
 		return null;
    }

    public function show(Camera $camera)
    {
    	$this->authorize('view',$camera);

 		return response()->JSON($camera);
    }

    public function update(Camera $camera)
    {
    	$this->authorize('update',$camera);
    	$attributes = $this->validateCamera();
    	$camera->update($attributes);

    	return response()->JSON($camera);
    }

    public function store()
    {
    	$attributes = $this->validateCamera();
    	$attributes['user_id'] = auth()->id();

 		$camera = Camera::create($attributes);

 		return response()->JSON($camera);
    }

    protected function validateCamera()
    {
    	return request()->validate([
    		'name' => 'required',
    		'intrinsic' => 'required',
    	]);
    }
}
