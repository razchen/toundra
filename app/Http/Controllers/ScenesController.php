<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;

class ScenesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
 		return view('scenes.index',[
 			'scenes' => auth()->user()->scenes
 		]);
    }

    public function create()
    {
 		return view('scenes.create',[
            'cameras' => auth()->user()->cameras
        ]);
    }

    public function edit(Scene $scene)
    {
        $cameras = auth()->user()->cameras;

 		return view('scenes.edit')->with(compact('scene','cameras'));
    }

    public function show(Scene $scene)
    {
    	$this->authorize('view',$scene);

 		return view('scenes.show')->with(compact('scene'));
    }

    public function update(Scene $scene)
    {
    	$this->authorize('update',$scene);

    	$attributes = $this->validateScene();

    	$scene->update($attributes);

    	return redirect('/scenes');
    }

    public function store(Scene $scene)
    {
        $this->authorize('store', $scene);

    	$attributes = $this->validateScene();
    	$attributes['user_id'] = auth()->id();

 		Scene::create($attributes);

 		return redirect('/scenes');
    }

    protected function validateScene()
    {
    	return request()->validate([
    		'name' => 'required',
    		'transforms' => 'required|json',
            'active' => 'required|in:0,1',
            'camera_id' => 'required',
    	]);
    }
}
