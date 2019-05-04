<?php

namespace App\Http\Controllers;

class UserPagesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Route to go to Resend Confirmation page
     *
     * @return View
     */
    public function resendConfirmation()
    {
        return view('user-pages.resend-confirmation'); 
    }

    public function resendConfirmationAjax()
    {
        if (!Auth::user()->confirmation) {
            $user = Auth::user();

            $sent = DB::table('sent_confirmations')
                ->where('user_id',$user->id)
                ->where('created_at','>',date('Y-m-d H:i:s',strtotime('-5 minutes')))
                ->first();

            if (!$sent) {
                DB::table('sent_confirmations')
                ->insert([
                    'user_id' => $user->id,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $actkey = $user->confirmation_code;
                $name = $user->name;
                $email = $user->email;
                $locale = App::getLocale();
                $from_email = Config::get('mail.from.address');
                $from_name = Config::get('app.name');
                

                $email_details = compact('actkey','name','email','locale','from_email','from_name');
                $this->dispatch(new SendConfirmationEmail($email_details));

                return response()->json(trans('b.upc_sent_confirmation'));
            } else {
                return response()->json(['errors' => ['user' => [trans('b.upc_already_sent')]]], 422);
            }
        } else {
            return response()->json(['errors' => ['user' => [trans('b.upc_already_confirm')]]], 422);
        }
    }

    public function uploadUserImage(Request $request)
    {
        $ret = array();
        if (Input::hasFile('filepond'))
        {
            $name = generateRandomString();
            $thumb_width = 400;
            $thumb_height = 400;
            $tmp_path = '/img/tmp/';
            $thumb_path = '/'.getImgFolder().'/users/';
            
            $ret = uploadImage(Input::file('filepond'), $name, $thumb_width, $thumb_height, $tmp_path, $thumb_path, false, false, true, false);
        }

        return response()->json($ret['file']);
    }
}
