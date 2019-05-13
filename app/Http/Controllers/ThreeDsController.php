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

    /**
     * Display a listing of the ThreeDs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = auth()->user()->type == 'admin' ? auth()->user()->adminThreeDs() : auth()->user()->three_ds;
        
        if (request()->wantsJson()) {
            return response()->JSON($response);
        } else {
            return view('user-pages.three_ds.reactive',[
                'three_ds' => $response
            ]);
        }
    }

     /**
     * Show the form for creating a new ThreeD.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.three_ds.reactive');
    }

    /**
     * Show the form for editing the specified ThreeD.
     *
     * @param  \App\ThreeD  $threeD
     * @return \Illuminate\Http\Response
     */
    public function edit(ThreeD $three_d, $model)
    {
        if (request()->wantsJson())
            return null;
        
    	$three_d = ThreeD::findOrFail($model);
        $three_d->getFiles($three_d);

        $this->authorize('view',$three_d);
        
 		return view('user-pages.three_ds.reactive')->with(compact('three_d'));
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
    	$this->authorize('view',$three_d);
        $three_d->getFiles($three_d);

        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->type == 'admin' ? $three_d->load('user') : $three_d);
        } else {
            return view('user-pages.three_ds.reactive')->with(compact('three_d'));
        }   
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
    	$this->authorize('update',$three_d);

    	$attributes = $this->validateThreeD();
        $attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

        if (request()->wantsJson()) {
            add3DFileRecord($three_d->id);

            $three_d->update($attributes);

            return response()->JSON($three_d);
        } else {
            validate3DFile(request()->file('3dfile'));

            $three_d->update($attributes);
            add3DFile($three_d->id);

            return redirect('/models');
        }
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
    	$attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

        if (request()->wantsJson()) {
            $three_d = ThreeD::create($attributes);
            add3DFileRecord($three_d->id);
            
            return response()->JSON($three_d);
        } else {
            validate3DFile(request()->file('3dfile'));

            $three_d = ThreeD::create($attributes);
            add3DFile($three_d->id);

            return redirect('/models');
        }
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
        $this->authorize('view',$three_d);
        $three_d->delete();
        DB::table('three_d_files')->where('three_d_id',$three_d->id)->delete();

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/models')->with('message','The model ' . $three_d->name . ' deleted successfully');
        }
    }

    /**
    * Uploads a 3d file to server
    *
    * @return \Illuminate\Http\Response
    */
    public function upload3DJSON()
    {
        $errors = validate3DFile(request()->file('filepond'));
        if ($errors) {
            return $errors;
        } else {
            return add3DFileJSON();    
        }
    }

      /**
     * Validate the specified ThreeD.
     *
     * @return  \Illuminate\Http\Request  $request
     */
    protected function validateThreeD()
    {
    	return request()->validate([
    		'name' => 'required',
    		'description' => 'required',
    	]);
    }
}
