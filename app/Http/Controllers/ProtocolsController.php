<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocol;

class ProtocolsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin');
	}

    public function index()
    {
 		return view('protocols.index',[
 			'protocols' => Protocol::orderBy('updated_at','desc')->get()
 		]);
    }

    public function create()
    {
 		return view('protocols.create');
    }

    public function edit(Protocol $protocol)
    {
 		return view('protocols.edit')->with(compact('protocol'));
    }

    public function show(Protocol $protocol)
    {
 		return view('protocols.show')->with(compact('protocol'));
    }

    public function update(Protocol $protocol)
    {
    	$attributes = $this->validateProtocol();

    	$protocol->update($attributes);

    	return redirect('/protocols');
    }

    public function store()
    {
    	$attributes = $this->validateProtocol();

 		Protocol::create($attributes);

 		return redirect('/protocols');
    }

    public function destroy(Protocol $protocol)
    {
        $protocol->delete();

        return redirect('/protocols')->with('message','The protocol ' . $protocol->name . ' deleted successfully');
    }

    protected function validateProtocol()
    {
    	return request()->validate([
    		'name' => 'required',
    		'description' => 'required',
            'json_data' => 'required|json',
    	]);
    }
}
