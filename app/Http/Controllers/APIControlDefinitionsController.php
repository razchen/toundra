<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Camera;
use App\Protocol;
use App\ControlDefinition;

class APIControlDefinitionsController extends Controller
{
    public function __construct()
	{
	}

    public function index()
    {
 		return response()->JSON(auth()->user()->control_definitions);
    }

    public function create()
    {
 		return null;
    }

    public function edit(ControlDefinition $control_definition)
    {
        return null;
    }

    public function show(ControlDefinition $control_definition)
    {
    	$this->authorize('view',$control_definition);

 		return response()->JSON($control_definition);
    }

    public function update(ControlDefinition $control_definition)
    {
    	$this->authorize('update',$control_definition);

    	$attributes = $this->validateControlDefinition();

    	$control_definition->update($attributes);

    	return response()->JSON($control_definition);
    }

    public function store(ControlDefinition $control_definition)
    {
        $this->authorize('store',$control_definition);

    	$attributes = $this->validateControlDefinition();
    	$attributes['user_id'] = auth()->id();

 		$control_definition = ControlDefinition::create($attributes);

 		return response()->JSON($control_definition);
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
