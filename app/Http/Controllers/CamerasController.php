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

    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.cameras.create');
    }

    public function edit(Camera $camera)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$camera);
        
 		return view('user-pages.cameras.edit')->with(compact('camera'));
    }

    public function show(Camera $camera)
    {
    	$this->authorize('view',$camera);

        if (request()->wantsJson()) {
            return response()->JSON($camera);
        } else {
            return view('user-pages.cameras.show')->with(compact('camera'));    
        }
    }

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

    protected function validateCamera()
    {
    	return request()->validate([
    		'name' => 'required',
    		'intrinsic' => 'required',
    	]);
    }
}
