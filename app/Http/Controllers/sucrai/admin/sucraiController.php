<?php

namespace App\Http\Controllers\sucrai\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;


class sucraiController extends Controller
{
    public function index(){
        $data = DB::table('users')->where('user_role', '=' ,  2)->get();

        if(count($data)<1){
            $data = 'false';
        }
        return view('admin.sucrai-leader.sucrai-leader' , compact('data'));

    }
    public function remove_sucrai($id){
           $leader = DB::table('users')->find($id);
           $result = DB::table('users')->where('id' , '=' , $id)->update([
               'user_role' => 0,
           ]);
             if($result== 1){
                 Session::flash('success', $leader->name . ' Is No longer Socrai Leader');
                 return redirect()->route('sucrai.leader');
             }
             else{
                 Session::flash('Failed', ' Something Went Wrong');
                 return redirect()->route('sucrai.leader');
             }
    }

    public function createSucrai (){
        $user = DB::table('users')->where('user_role','=' , '0')->get();
        return view('admin.sucrai-leader.add',compact('user'));
    }
    public function make_sucrai($id){
       $leader = DB::table('users')->find($id);
       $result = DB::table('users')->where('id' , $id)->update([
           'user_role' => 2,
       ]);

        if($result== 1){
            Session::flash('success', $leader->name . ' Is Now a Socrai Leader');
            return redirect()->route('sucrai.leader');
        }
        else{
            Session::flash('Failed', ' Something Went Wrong');
            return redirect()->route('sucrai.leader');
        }

    }

}
