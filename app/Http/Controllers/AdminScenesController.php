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

    public function index()
    {
 		return view('admin-pages.scenes.index',[
 			'scenes' => Scene::orderBy('updated_at','desc')->get()
 		]);
    }

    public function create()
    {
 		return view('admin-pages.scenes.create',[
            'cameras' => Camera::orderBy('name','asc')->get(),
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    public function edit(Scene $scene)
    {
        $cameras = Camera::orderBy('name','asc')->get();
        $users = User::orderBy('name','asc')->get();

 		return view('admin-pages.scenes.edit')->with(compact('scene','cameras','users'));
    }

    public function show(Scene $scene)
    {
 		return view('admin-pages.scenes.show')->with(compact('scene'));
    }

    public function update(Scene $scene)
    {
    	$attributes = $this->validateScene();

    	$scene->update($attributes);

    	return redirect('/admin/scenes');
    }

    public function store(Scene $scene)
    {
    	$attributes = $this->validateScene();

 		Scene::create($attributes);

 		return redirect('/admin/scenes');
    }

    public function destroy(Scene $scene)
    {
        $scene->delete();

        return redirect('/scenes');
    }

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
