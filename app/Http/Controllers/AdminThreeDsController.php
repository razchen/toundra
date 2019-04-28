<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThreeD;
use App\User;
use DB;

class AdminThreeDsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    public function index()
    {
 		return view('admin-pages.three_ds.index',[
 			'three_ds' => ThreeD::orderBy('updated_at','desc')->get()
 		]);
    }

    public function create()
    {
 		return view('admin-pages.three_ds.create',[
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    public function edit(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);
        $users = User::orderBy('name','asc')->get();
 		return view('admin-pages.three_ds.edit')->with(compact('three_d','users'));
    }

    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);

 		return view('admin-pages.three_ds.show')->with(compact('three_d'));
    }

    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);

    	$attributes = $this->validateThreeD();
        validate3DFile(request()->file('3dfile'));

        $three_d->update($attributes);
        add3DFile($three_d->id);

    	return redirect('/admin/models');
    }

    public function store()
    {
    	$attributes = $this->validateThreeD();
        validate3DFile(request()->file('3dfile'));

        $three_d = ThreeD::create($attributes);
        add3DFile($three_d->id);

 		return redirect('/admin/models');
    }

    public function destroy(ThreeD $three_d, $model)
    {
        $three_d = ThreeD::findOrFail($model);
        $three_d->delete();
        DB::table('three_d_files')->where('three_d_id',$three_d->id)->delete();

        return redirect('/admin/models');
    }

    protected function validateThreeD()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
