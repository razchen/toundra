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

    /**
     * Display a listing of the Scenes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = auth()->user()->type == 'admin' ? auth()->user()->adminScenes() : auth()->user()->scenes;
        if (request()->wantsJson()) {
            return response()->JSON($response);
        } else {
            return view('user-pages.scenes.reactive',[
                'scenes' => $response
            ]);
        }
    }

    /**
     * Show the form for creating a new Scene.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.scenes.reactive',[
            'cameras' => auth()->user()->cameras
        ]);
    }

      /**
     * Show the form for editing the specified Scene.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function edit(Scene $scene)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$scene);
        $cameras = auth()->user()->cameras;

 		return view('user-pages.scenes.reactive')->with(compact('scene','cameras'));
    }

    /**
     * Display the specified Scene.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function show(Scene $scene)
    {
    	$this->authorize('view',$scene);

        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->type == 'admin' ? $scene->load('user','camera') : $scene->load('camera'));
        } else {
            return view('user-pages.scenes.reactive')->with(compact('scene'));
        }	
    }

    /**
     * Update the specified Scene in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function update(Scene $scene)
    {
    	$this->authorize('update',$scene);

    	$attributes = $this->validateScene();
        $attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

    	$scene->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($scene);
        } else {
            return redirect('/scenes');
        }
    }

    /**
     * Store a newly created Scene in storage.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function store(Scene $scene)
    {
        $this->authorize('store', $scene);

    	$attributes = $this->validateScene();
    	$attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

 		$scene = Scene::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($scene);
        } else {
            return redirect('/scenes');
        }
    }

     /**
     * Remove the specified Scene from storage.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scene $scene)
    {
        $this->authorize('view',$scene);
        
        $scene->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/scenes')->with('message','The scene ' . $scene->name . ' deleted successfully');
        }
    }

     /**
     * Validate the specified scene.
     *
     * @return \Illuminate\Http\Request  $request
     */
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
