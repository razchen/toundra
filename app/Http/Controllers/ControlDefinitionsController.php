<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\Protocol;
use App\ControlDefinition;

class ControlDefinitionsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
 		return view('user-pages.control-definitions.index',[
 			'control_definitions' => auth()->user()->control_definitions
 		]);
    }

    public function create()
    {
 		return view('user-pages.control-definitions.create',[
            'three_ds' => auth()->user()->three_ds,
            'protocols' => Protocol::all()
        ]);
    }

    public function edit(ControlDefinition $control_definition)
    {
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

 		return view('user-pages.control-definitions.show')->with(compact('control_definition'));
    }

    public function update(ControlDefinition $control_definition)
    {
    	$this->authorize('update',$control_definition);

    	$attributes = $this->validateControlDefinition();

    	$control_definition->update($attributes);

    	return redirect('/control-definitions');
    }

    public function store(ControlDefinition $control_definition)
    {
        $this->authorize('store',$control_definition);

    	$attributes = $this->validateControlDefinition();
    	$attributes['user_id'] = auth()->id();

 		ControlDefinition::create($attributes);

 		return redirect('/control-definitions');
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
