<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;

class CamerasController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
 		return view('user-pages.cameras.index',[
 			'cameras' => auth()->user()->cameras
 		]);
    }

    public function create()
    {
 		return view('user-pages.cameras.create');
    }

    public function edit(Camera $camera)
    {
        $this->authorize('view',$camera);
        
 		return view('user-pages.cameras.edit')->with(compact('camera'));
    }

    public function show(Camera $camera)
    {
    	$this->authorize('view',$camera);

 		return view('user-pages.cameras.show')->with(compact('camera'));
    }

    public function update(Camera $camera)
    {
    	$this->authorize('update',$camera);

    	$attributes = $this->validateCamera();
    	$camera->update($attributes);

    	return redirect('/cameras');
    }

    public function store()
    {
    	$attributes = $this->validateCamera();
    	$attributes['user_id'] = auth()->id();

 		Camera::create($attributes);

 		return redirect('/cameras');
    }

    protected function validateCamera()
    {
    	return request()->validate([
    		'name' => 'required',
    		'intrinsic' => 'required',
    	]);
    }
}
