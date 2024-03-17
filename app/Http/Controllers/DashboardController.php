<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Package;
use Auth;
use App\MC;
// use App\Driver;
use App\Car;
use App\User_Activity;
use DB;
use Carbon;
use Session;
use App\Subscribers;
use Mail;
use App\Blog;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('AdminAccess');
    }
    public function index()
    {
        $user = Auth::user();
        if($user->user_role==0)
        {
            Session::flash('message','Admin, Socrai Leader, Tribe Leaders are allowed to login.');
			Auth::logout();
			return redirect('/login');
        }

        return view("admin.dashboard.home");
    }

    

    


}

