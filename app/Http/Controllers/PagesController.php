<?php

namespace App\Http\Controllers;
use Auth;

class PagesController extends Controller
{
    public function __construct() {
    }

    /**
     * Route to go to Home page
     *
     * @return View
     */
    public function home() {
        if (Auth::check()) {
            if (Auth::user()->type == 'admin')
                return redirect ('/admin/cameras');
            else
                return redirect('/cameras');
        }

        return view('home');
    }

    /**
     * Route to go to Contact page
     *
     * @return View
     */
    public function contact() {
        return view('pages.contact');
    }

    /**
     * Route to go to Dashboard page
     *
     * @return View
     */
    public function dashboard() {
        return view('pages.dashboard');
    }

    /**
     * Route to go to About page
     *
     * @return View
     */
    public function about() {
        return view('pages.about');
    }

    /**
     * Route to go to FAQ page
     *
     * @return View
     */
    public function faq() {
        return view('pages.faq');
    }

    /**
     * Route to go to Terms page
     *
     * @return View
     */
    public function terms() {
        return view('pages.terms');
    }

    /**
     * Route to go to Contact page
     *
     * @return View
     */
    public function postContact(Request $request)
    {
        $error = false;

        $name = Input::get('fullname');
        $email = Input::get('email');
        $message = Input::get('message');

        $recaptcha_secret = Config::get('constants.recaptcha.secret');

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$recaptcha_secret."&response=".Input::get('g-recaptcha-response'), false, stream_context_create($arrContextOptions));
        $response = json_decode($response, true);

        if($response["success"] !== true)
        {
            $error = trans('b.pc_robot');
        }

        //Check if message has been entered
        if (!$message) {
            $error = trans('b.pc_fill_message');
        }

        // Check if email has been entered and is valid
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = trans('b.pc_fill_email');
        }

        // Check if name has been entered
        if (!$name) {
            $error = trans('b.pc_fill_name');
        }

        // If there are no errors, send the email
        if (!$error) {
            include(app_path().'/includes/GeoIP/geoip.inc');
            $gi = geoip_open(app_path().'/includes/GeoIP/GeoIP.dat',GEOIP_STANDARD);
            $country = geoip_country_name_by_addr($gi, getIpAddress());

            $body = $message."<br><br>".'Name: '.$name."<br>IP: ".getIpAddress()."<br>Country: ".$country."<br>Email: ".$email;
            $locale = App::getLocale();
            $from_email = Config::get('mail.from.address');
            $from_name = Config::get('app.name');

            $email_details = compact('name','email','body','locale','from_email','from_name');
            
            dispatch(new SendContactEmail($email_details));

            $error = 'sent';
            $request->session()->flash('alert-success', trans('b.pc_message_sent'));
        } else {
            $request->session()->flash('alert-danger', $error);
        }

        return Redirect::to('/contact-us');
    }

    public function confirmEmail($confirmation_code,Request $request)
    {
        if( ! $confirmation_code)
        {
            return redirect('/');
        }

        $user = User::whereConfirmationCode($confirmation_code)->first();

        if ( ! $user)
        {
            return redirect('/');
        }

        $user->confirmed = 1;
        $user->confirmation_code = $confirmation_code;
        $user->save();

        $request->session()->flash('alert-success', 'Your email address is now confirmed!');
        return redirect('/');
    }
}
