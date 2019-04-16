<?php

namespace App\Http\Controllers;

class AdminTestController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function sendTestEmail()
    {
        $actkey = '';
        $name = 'gptraz@gmail.com';

        Mail::send('emails.verify', compact('actkey','name'), function($message)  {
            $message->from('support@kiwiwall.com','Kiwi Wall');
            $message->to('gptraz@gmail.com', 'Raz')
                ->subject('Welcome to Kiwi Wall');
        });
    }

    public function createError()
    {
        DB::table('asd')
            ->get();

    }
}