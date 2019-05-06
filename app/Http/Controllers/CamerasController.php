<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\Scene;

class CamerasController extends Controller
{
    public function __construct()
	{
        if (!request()->wantsJson()) {
            $this->middleware('auth');    
        }
	}

    /**
     * Display a listing of the Cameras.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->cameras);
        } else {
            return view('user-pages.cameras.index',[
                'cameras' => auth()->user()->cameras
            ]);    
        }
    }

    /**
     * Show the form for creating a new Camera.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.cameras.create');
    }

    /**
     * Show the form for editing the specified Camera.
     *
     * @param  \App\Camera  $scene
     * @return \Illuminate\Http\Response
     */
    public function edit(Camera $camera)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$camera);
        
 		return view('user-pages.cameras.edit')->with(compact('camera'));
    }

    /**
     * Display the specified Camera.
     *
     * @param  \App\Camera  $scene
     * @return \Illuminate\Http\Response
     */
    public function show(Camera $camera)
    {
    	$this->authorize('view',$camera);

        if (request()->wantsJson()) {
            return response()->JSON($camera);
        } else {
            return view('user-pages.cameras.show')->with(compact('camera'));    
        }
    }

    /**
     * Update the specified Camera in storage.
     *
     * @param  \App\Camera  $scene
     * @return \Illuminate\Http\Response
     */
    public function update(Camera $camera)
    {
    	$this->authorize('update',$camera);

    	$attributes = $this->validateCamera();
    	$camera->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($camera);
        } else {
            return redirect('/cameras');
        }
    }

    /**
     * Store a newly created Camera in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    	$attributes = $this->validateCamera();
    	$attributes['user_id'] = auth()->id();

 		$camera = Camera::create($attributes);

 		if (request()->wantsJson()) {
            return response()->JSON($camera);
        } else {
            return redirect('/cameras');
        }
    }

    /**
     * Remove the specified Camera from storage.
     *
     * @param  \App\Camera  $scene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camera $camera)
    {
        if ($camera->user_id != auth()->user()->id) {
            abort(403);
        } else {
            Scene::where('camera_id',$camera->id)->delete();
            $camera->delete();
        }

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/cameras')->with('message','The camera ' . $camera->name . ' deleted successfully');
        }
    }

     /**
     * Validate the specified camera.
     *
     * @return  \App\Camera  $camera
     */
    protected function validateCamera()
    {
    	return request()->validate([
    		'name' => 'required',
    		'intrinsic' => 'required',
    	]);
    }
}
