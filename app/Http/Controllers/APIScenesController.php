<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;

class APIScenesController extends Controller
{
    public function index()
    {
        return response()->JSON(auth()->user()->scenes);
    }

    public function create()
    {
 		return null;
    }

    public function edit(Scene $scene)
    {
        return null;
    }

    public function show(Scene $scene)
    {
    	$this->authorize('view',$scene);

        return response()->JSON($scene);
    }

    public function update(Scene $scene)
    {
    	$this->authorize('update',$scene);

    	$attributes = $this->validateScene();

    	$scene->update($attributes);

    	return response()->JSON($scene);
    }

    public function store(Scene $scene)
    {
        $this->authorize('store', $scene);

    	$attributes = $this->validateScene();
    	$attributes['user_id'] = auth()->id();

 		$scene = Scene::create($attributes);

 		return response()->JSON($scene);
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
