<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Mail;
use Share;
use Carbon;
use Session;
use App\User;
use DateTime;
use Location;
use Exception;
use App\Article;
use App\Mail\Notifications;
use Illuminate\Support\Str;
// use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('DeleteLogout');
    }

  
    public function redirect()
    {
        if(Auth::check())
        {
            return redirect(url()->previous());
        } else {
            return redirect('/frontend/#/');
        }
    }
    /**
     * Show the application Homepage.
     *
     * @return \Illuminate\Http\Response
     */

    

    public function terms()
    {
        $data['title']= 'Terms';
        return view('terms',$data);
    }
    public function privacy()
    {
        $data['title']= 'Privacy Policy';
        return view('privacy',$data);
    }
    


    

   
}
