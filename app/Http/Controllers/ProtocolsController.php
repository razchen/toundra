<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocol;

class ProtocolsController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
        $this->middleware('admin', ['except' => ['index']]);
	}

     /**
     * Display a listing of the Protocols.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->JSON(Protocol::orderBy('updated_at','desc')->get());
        } else {
            return view('user-pages.protocols.reactive',[
                'protocols' => Protocol::orderBy('updated_at','desc')->get()
            ]);
        }
    }

    /**
     * Show the form for creating a new Protocol.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.protocols.reactive');
    }

     /**
     * Show the form for editing the specified Protocol.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function edit(Protocol $protocol)
    {
        if (request()->wantsJson())
            return null;

 		return view('user-pages.protocols.reactive')->with(compact('protocol'));
    }

     /**
     * Display the specified Protocol.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function show(Protocol $protocol)
    {
        if (request()->wantsJson()) {
            return response()->JSON($protocol);
        } else {
            return view('user-pages.protocols.reactive')->with(compact('protocol'));
        }   
    }

    /**
     * Update the specified Protocol in storage.
     *
     * @param  \App\Protocol  $protocol
     * @return \Illuminate\Http\Response
     */
    public function update(Protocol $protocol)
    {
    	$attributes = $this->validateProtocol();

    	$protocol->update($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($protocol);
        } else {
            return redirect('/protocols');
        }
    }

    /**
     * Store a newly created Protocol in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
    	$attributes = $this->validateProtocol();

 		$protocol = Protocol::create($attributes);

        if (request()->wantsJson()) {
            return response()->JSON($protocol);
        } else {
            return redirect('/protocols');
        }
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

        if (request()->wantsJson()) {
            return response()->JSON(['status' => 'success']);
        } else {
            return redirect('/protocols')->with('message','The protocol ' . $protocol->name . ' deleted successfully');
        }
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
