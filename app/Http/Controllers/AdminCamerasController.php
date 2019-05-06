<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\User;
use App\Scene;
use DB;

class AdminCamerasController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    /**
     * Display a listing of the Cameras.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.cameras.index',[
 			'cameras' => Camera::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new Camera.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.cameras.create',[
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    /**
     * Show the form for editing the specified Camera.
     *
     * @param  \App\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function edit(Camera $camera)
    {
        $users = User::orderBy('name','asc')->get();
 		return view('admin-pages.cameras.edit')->with(compact('camera','users'));
    }

    /**
     * Display the specified Camera.
     *
     * @param  \App\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function show(Camera $camera)
    {
 		return view('admin-pages.cameras.show')->with(compact('camera'));
    }

    /**
     * Update the specified Camera in storage.
     *
     * @param  \App\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function update(Camera $camera)
    {
    	$attributes = $this->validateCamera();

    	$camera->update($attributes);

    	return redirect('/admin/cameras');
    }

    /**
     * Store a newly created Camera in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    	$attributes = $this->validateCamera();

 		Camera::create($attributes);

 		return redirect('/admin/cameras');
    }

    /**
     * Remove the specified Camera from storage.
     *
     * @param  \App\Camera  $camera
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camera $camera)
    {
        Scene::where('camera_id',$camera->id)->delete();
        $camera->delete();

        return redirect('/admin/cameras')->with('message','The camera ' . $camera->name . ' deleted successfully');
    }

    /**
     * Validate the specified Camera.
     *
     * @return  \App\Camera  $camera
     */
    protected function validateCamera()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'intrinsic' => 'required',
    	]);
    }
}
