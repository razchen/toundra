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

    public function index()
    {
        if (request()->wantsJson()) {
            return response()->JSON(auth()->user()->control_definitions);
        } else {
            return view('user-pages.control-definitions.index',[
                'control_definitions' => auth()->user()->control_definitions
            ]);
        }
    }

    public function create()
    {
        if (request()->wantsJson())
            return null;
        
 		return view('user-pages.control-definitions.create',[
            'three_ds' => auth()->user()->three_ds,
            'protocols' => Protocol::all()
        ]);
    }

    public function edit(ControlDefinition $control_definition)
    {
        if (request()->wantsJson())
            return null;
        
        $this->authorize('view',$control_definition);
        
 		return view('user-pages.control-definitions.edit',[
            'three_ds' => auth()->user()->three_ds,
            'protocols' => Protocol::all(),
            'control_definition' => $control_definition
        ]);
    }

    public function show(ControlDefinition $control_definition)
    {
    	$this->authorize('view',$control_definition);
 		
        if (request()->wantsJson()) {
            return response()->JSON($control_definition);
        } else {
            return view('user-pages.control-definitions.show')->with(compact('control_definition'));
        }   
    }

    public function update(ControlDefinition $control_definition)
    {
    	$this->authorize('update',$control_definition);

    	$attributes = $this->validateControlDefinition();

    	$control_definition->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($control_definition);
        } else {
            return redirect('/control-definitions');
        }
    }

    public function store(ControlDefinition $control_definition)
    {
        $this->authorize('store',$control_definition);

    	$attributes = $this->validateControlDefinition();
    	$attributes['user_id'] = auth()->id();

 		$control_definition = ControlDefinition::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($control_definition);
        } else {
            return redirect('/control-definitions');
        }
    }

    public function destroy(ControlDefinition $control_definition)
    {
        if ($control_definition->user_id != auth()->user()->id) {
            abort(403);
        } else {
            Report::where('control_definition_id',$control_definition->id)->delete();
            $control_definition->delete();
        }
         
        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/control-definitions')->with('message','The control definition ' . $control_definition->name . ' deleted successfully');
        }
    }

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
