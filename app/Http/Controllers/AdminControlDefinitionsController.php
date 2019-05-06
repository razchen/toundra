<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocol;
use App\ControlDefinition;
use App\ThreeD;
use App\User;
use App\Report;

class AdminControlDefinitionsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

    /**
     * Display a listing of the ControlDefinitions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('admin-pages.control-definitions.index',[
 			'control_definitions' => ControlDefinition::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new ControlDefinition.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('admin-pages.control-definitions.create',[
            'users' => User::orderBy('name','asc')->get(),
            'three_ds' => ThreeD::orderBy('name','asc')->get(),
            'protocols' => Protocol::orderBy('name','asc')->get()
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
 		return view('admin-pages.control-definitions.edit',[
            'users' => User::orderBy('name','asc')->get(),
            'three_ds' => ThreeD::orderBy('name','asc')->get(),
            'protocols' => Protocol::orderBy('name','asc')->get(),
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
 		return view('admin-pages.control-definitions.show')->with(compact('control_definition'));
    }

    /**
     * Update the specified ControlDefinition in storage.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function update(ControlDefinition $control_definition)
    {
    	$attributes = $this->validateControlDefinition();

    	$control_definition->update($attributes);

    	return redirect('/admin/control-definitions');
    }

    /**
     * Store a newly created ControlDefinition in storage.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function store(ControlDefinition $control_definition)
    {
    	$attributes = $this->validateControlDefinition();

 		ControlDefinition::create($attributes);

 		return redirect('/admin/control-definitions');
    }

    /**
     * Remove the specified ControlDefinition from storage.
     *
     * @param  \App\ControlDefinition  $control_definition
     * @return \Illuminate\Http\Response
     */
    public function destroy(ControlDefinition $control_definition)
    {
        Report::where('control_definition_id',$control_definition->id)->delete();
        $control_definition->delete();

        return redirect('/admin/control-definitions')->with('message','The control definition ' . $control_definition->name . ' deleted successfully');
    }

    /**
     * Validate the specified control definition.
     *
     * @return  \Illuminate\Http\Request  $request
     */
    protected function validateControlDefinition()
    {
    	return request()->validate([
            'user_id' => 'required',
            'three_d_id' => 'required|numeric',
            'protocol_id' => 'required|numeric',
    		'name' => 'required',
    		'description' => 'required',
            'json_data' => 'required|json',
    	]);
    }
}
