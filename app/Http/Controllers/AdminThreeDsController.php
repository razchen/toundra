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

    /**
     * Display a listing of the ThreeDs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.three_ds.index',[
 			'three_ds' => ThreeD::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new ThreeD.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.three_ds.create',[
            'users' => User::orderBy('name','asc')->get()
        ]);
    }

    /**
     * Show the form for editing the specified ThreeD.
     *
     * @param  \App\ThreeD  $threeD
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);
        $users = User::orderBy('name','asc')->get();
 		return view('admin-pages.three_ds.edit')->with(compact('three_d','users'));
    }

    /**
     * Display the specified ThreeD.
     *
     * @param  \App\ThreeD  $threeD
     * @return \Illuminate\Http\Response
     */
    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);

 		return view('admin-pages.three_ds.show')->with(compact('three_d'));
    }

    /**
     * Update the specified ThreeD in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ThreeD  $threeD
     * @return \Illuminate\Http\Response
     */
    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);

    	$attributes = $this->validateThreeD();
        validate3DFile(request()->file('3dfile'));

        $three_d->update($attributes);
        add3DFile($three_d->id);

    	return redirect('/admin/models');
    }

    /**
     * Store a newly created ThreeD in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    	$attributes = $this->validateThreeD();
        validate3DFile(request()->file('3dfile'));

        $three_d = ThreeD::create($attributes);
        add3DFile($three_d->id);

 		return redirect('/admin/models');
    }

    /**
     * Remove the specified ThreeD from storage.
     *
     * @param  \App\ThreeD  $threeD
     * @return \Illuminate\Http\Response
     */
    public function destroy(ThreeD $three_d, $model)
    {
        $three_d = ThreeD::findOrFail($model);
        $three_d->delete();
        DB::table('three_d_files')->where('three_d_id',$three_d->id)->delete();

        return redirect('/admin/models')->with('message','The model ' . $three_d->name . ' deleted successfully');
    }

    /**
     * Validate the specified ThreeD.
     *
     * @return  \App\ThreeD  $threeD
     */
    protected function validateThreeD()
    {
    	return request()->validate([
            'user_id' => 'required|exists:users,id',
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
