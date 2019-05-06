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

     /**
     * Display a listing of the Protocols.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 		return view('protocols.index',[
 			'protocols' => Protocol::orderBy('updated_at','desc')->get()
 		]);
    }

    /**
     * Show the form for creating a new Protocol.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 		return view('protocols.create');
    }

     /**
     * Show the form for editing the specified Protocol.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
 		return view('protocols.edit')->with(compact('protocol'));
    }

     /**
     * Display the specified Protocol.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Protocol $protocol)
    {
 		return view('protocols.show')->with(compact('protocol'));
    }

    /**
     * Update the specified Protocol in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Protocol $protocol)
    {
    	$attributes = $this->validateProtocol();

    	$protocol->update($attributes);

    	return redirect('/protocols');
    }

    /**
     * Store a newly created Protocol in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    	$attributes = $this->validateProtocol();

 		Protocol::create($attributes);

 		return redirect('/protocols');
    }

    /**
     * Remove the specified Protocol from storage.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function destroy(Protocol $protocol)
    {
        $protocol->delete();

        return redirect('/protocols')->with('message','The protocol ' . $protocol->name . ' deleted successfully');
    }

    /**
     * Validate the specified protocol.
     *
     * @return  \Illuminate\Http\Request  $request
     */
    protected function validateProtocol()
    {
    	return request()->validate([
    		'name' => 'required',
    		'description' => 'required',
            'json_data' => 'required|json',
    	]);
    }
}
