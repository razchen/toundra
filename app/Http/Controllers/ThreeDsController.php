<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ThreeD;
use DB;

class ThreeDsController extends Controller
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
            return response()->JSON(auth()->user()->three_ds);
        } else {
            return view('user-pages.three_ds.index',[
                'three_ds' => auth()->user()->three_ds
            ]);
        }
    }

    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.three_ds.create');
    }

    public function edit(ThreeD $three_d, $model)
    {
        if (request()->wantsJson())
            return null;
        
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);

        $this->authorize('view',$three_d);
        
 		return view('user-pages.three_ds.edit')->with(compact('three_d'));
    }

    public function show(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('view',$three_d);
        $three_d->getFiles($three_d);

        if (request()->wantsJson()) {
            return response()->JSON($three_d);
        } else {
            return view('user-pages.three_ds.show')->with(compact('three_d'));
        }   
    }

    public function update(ThreeD $three_d, $model)
    {
    	$three_d = ThreeD::findOrFail($model);
    	$this->authorize('update',$three_d);

    	$attributes = $this->validateThreeD();
        validate3DFile(request()->file('3dfile'));

    	$three_d->update($attributes);
        add3DFile($three_d->id);

        if (request()->wantsJson()) {
            return response()->JSON($three_d);
        } else {
            return redirect('/models');
        }
    }

    public function store()
    {
    	$attributes = $this->validateThreeD();
    	$attributes['user_id'] = auth()->id();
        validate3DFile(request()->file('3dfile'));

        $three_d = ThreeD::create($attributes);
        add3DFile($three_d->id);
 		
        if (request()->wantsJson()) {
            return response()->JSON($three_d);
        } else {
            return redirect('/models');
        }
    }

    public function destroy(ThreeD $three_d, $model)
    {
        $three_d = ThreeD::findOrFail($model);
        $three_d->user_id != auth()->user()->id ? abort(403) : $three_d->delete();
        DB::table('three_d_files')->where('three_d_id',$three_d->id)->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/models');
        }
    }

    protected function validateThreeD()
    {
    	return request()->validate([
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
