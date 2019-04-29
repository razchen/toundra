<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;

class ScenesController extends Controller
{
    public function __construct()
	{
		if (!request()->wantsJson()) {
            $this->middleware('auth');    
        }
	}

    public function index()
    {
        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->scenes);
        } else {
            return view('user-pages.scenes.index',[
                'scenes' => auth()->user()->scenes
            ]);
        }
    }

    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.scenes.create',[
            'cameras' => auth()->user()->cameras
        ]);
    }

    public function edit(Scene $scene)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$scene);
        $cameras = auth()->user()->cameras;

 		return view('user-pages.scenes.edit')->with(compact('scene','cameras'));
    }

    public function show(Scene $scene)
    {
    	$this->authorize('view',$scene);

        if (request()->wantsJson()) {
            return response()->JSON($scene);
        } else {
            return view('user-pages.scenes.show')->with(compact('scene'));
        }	
    }

    public function update(Scene $scene)
    {
    	$this->authorize('update',$scene);

    	$attributes = $this->validateScene();

    	$scene->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($scene);
        } else {
            return redirect('/scenes');
        }
    }

    public function store(Scene $scene)
    {
        $this->authorize('store', $scene);

    	$attributes = $this->validateScene();
    	$attributes['user_id'] = auth()->id();

 		$scene = Scene::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($scene);
        } else {
            return redirect('/scenes');
        }
    }

    public function destroy(Scene $scene)
    {
        $scene->user_id != auth()->user()->id ? abort(403) : $scene->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/scenes')->with('message','The scene ' . $scene->name . ' deleted successfully');
        }
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
