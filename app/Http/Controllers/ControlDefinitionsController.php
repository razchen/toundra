<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\Protocol;
use App\ControlDefinition;
use App\Report;

class ControlDefinitionsController extends Controller
{
    public function __construct()
	{
		if (!request()->wantsJson()) {
            $this->middleware('auth');    
        }
	}

    /**
     * Display a listing of the ControlDefinitions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = auth()->user()->type == 'admin' ? auth()->user()->adminControlDefinitions() : auth()->user()->control_definitions;
        if (request()->wantsJson()) {
            return response()->JSON($response);
        } else {
            return view('user-pages.control-definitions.reactive',[
                'control_definitions' => $response
            ]);
        }
    }

    /**
     * Show the form for creating a new ControlDefinition.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.control-definitions.reactive',[
            'three_ds' => auth()->user()->three_ds,
            'protocols' => Protocol::all()
        ]);
    }

    /**
     * Show the form for editing the specified ControlDefinition.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function edit(ControlDefinition $control_definition)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$control_definition);
        
 		return view('user-pages.control-definitions.reactive',[
            'three_ds' => auth()->user()->three_ds,
            'protocols' => Protocol::all(),
            'control_definition' => $control_definition
        ]);
    }

    /**
     * Display the specified ControlDefinition.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function show(ControlDefinition $control_definition)
    {
    	$this->authorize('view',$control_definition);
 		
        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->type == 'admin' ? $control_definition->load('user','protocol','three_d') : $control_definition->load('protocol','three_d'));
        } else {
            return view('user-pages.control-definitions.reactive')->with(compact('control_definition'));
        }   
    }

    /**
     * Update the specified ControlDefinition in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function update(ControlDefinition $control_definition)
    {
    	$this->authorize('update',$control_definition);

    	$attributes = $this->validateControlDefinition();
        $attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

    	$control_definition->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($control_definition);
        } else {
            return redirect('/control-definitions');
        }
    }

    /**
     * Store a newly created ControlDefinition in storage.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function store(ControlDefinition $control_definition)
    {
        $this->authorize('store',$control_definition);

    	$attributes = $this->validateControlDefinition();
    	$attributes['user_id'] = auth()->user()->type == 'admin' ? request()->get('user_id') : auth()->id();

 		$control_definition = ControlDefinition::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($control_definition);
        } else {
            return redirect('/control-definitions');
        }
    }

    /**
     * Remove the specified ControlDefinition from storage.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ControlDefinition $control_definition)
    {
        $this->authorize('view',$control_definition);

        Report::where('control_definition_id',$control_definition->id)->delete();
        $control_definition->delete();
         
        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/control-definitions')->with('message','The control definition ' . $control_definition->name . ' deleted successfully');
        }
    }

    /**
     * Validate the specified control definition.
     *
     * @return  \Illuminate\Http\Request  $request
     */
    protected function validateControlDefinition()
    {
    	return request()->validate([
            'three_d_id' => 'required|numeric',
            'protocol_id' => 'required|numeric',
    		'name' => 'required',
    		'description' => 'required',
            'json_data' => 'required|json',
    	]);
    }
}
