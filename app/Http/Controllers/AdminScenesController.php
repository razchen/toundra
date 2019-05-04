<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Scene;
use App\Camera;
use App\User;

class AdminScenesController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    /**
     * Display a listing of the Scenes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.scenes.index',[
 			'scenes' => Scene::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new Scene.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.scenes.create',[
            'cameras' => Camera::orderBy('name','asc')->get(),
            'users' => User::orderBy('name','asc')->get()
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
        $cameras = Camera::orderBy('name','asc')->get();
        $users = User::orderBy('name','asc')->get();

 		return view('admin-pages.scenes.edit')->with(compact('scene','cameras','users'));
    }

    /**
     * Display the specified Scene.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function show(Scene $scene)
    {
 		return view('admin-pages.scenes.show')->with(compact('scene'));
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
    	$attributes = $this->validateScene();

    	$scene->update($attributes);

    	return redirect('/admin/scenes');
    }

    /**
     * Store a newly created Scene in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Scene $scene)
    {
    	$attributes = $this->validateScene();

 		Scene::create($attributes);

 		return redirect('/admin/scenes');
    }

    /**
     * Remove the specified Scene from storage.
     *
     * @param  \App\Scene  $scene
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scene $scene)
    {
        $scene->delete();

        return redirect('/admin/scenes')->with('message','The scene ' . $scene->name . ' deleted successfully');
    }

    /**
     * Validate the specified scene.
     *
     * @return  \App\Scene  $scene
     */
    protected function validateScene()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'transforms' => 'required|json',
            'active' => 'required|in:0,1',
            'camera_id' => 'required',
    	]);
    }
}
