<?php

namespace App;

use App\Models\sucrai\admin\User_tribe;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',

    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      
       'name',
       'image', 
       'email', 
       'phone_number', 
       'password' ,
       'user_role', 
       'company_id', 
       'created_date', 'created_by_admin',
       'street_no','street_name' , 'city', 'state', 'zip_code',
       
       
    ];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'password', 'remember_token', 'api_token',
    ];


    public function coupon()
    {
        return $this->hasMany('App\Coupon');
    }

    public function  editUser($id){
        $user = User::find($id);

        $tribeUser = DB::table('user_tribes')->where('user_id' , '=' , $id)->pluck('tribe_id');
        $tribe  = DB::table('tribes')->whereNotIn('id' , $tribeUser)->get();
        return [$user , $tribe];
    }
    public function indexUser(){
        $users = User::where('user_role' , '!=' , '1' )->get();
        foreach ($users as $us){
            $usertribe = DB::table('user_tribes')->where('user_id', '=' , $us->id)->pluck('tribe_id');
            $tribe = DB::table('tribes')->whereIn('id' , $usertribe)->get();
            $us->tribe = $tribe ;
        }
//dd($users);
        return $users;
    }
    public function createUser(){

//        $companies = DB::table('companies')->get();
        return '';
    }

    public function updatedata($request){
       // dd($request);
       if($files=$request->file('image')) {
            $name = $files->getClientOriginalName();
            $ext =  $files->getClientOriginalExtension();
            $name = date('d_m_y') . '_' . time() . '_image.'.$ext;
            // $files->move(public_path('images\sucrai'), $name);
            $files->move(public_path('images/sucrai'), $name);
        }
        else{
          $name = User::where('id', $request['id'])->pluck('image')->first();
          // dd($name);
        }


        if($request->tribe_id) {
            DB::table('user_tribes')->insert([
              'user_id' => $request->id,
              'tribe_id' => $request->tribe_id,
            ]);
           }
       $data = User::where('id', $request['id'])
            ->update([
                'name' => $request['name'],
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                "updated_at" => carbon::now(),
                "image" => $name,

            ]);
      // dd($data);
       return $data;

    }

    public function savedata($request){

       

        if($files=$request->file('image')) {
            $name = $files->getClientOriginalName();
             $ext = $files->getClientOriginalExtension();
            $name = date('d_m_y') . '_' . time() . '_image.'.$ext;
            // $files->move(public_path('images\sucrai'), $name);
            $files->move(public_path('images/sucrai'), $name);
        }
        else{
          $name = 'abc.png';
        }
       
      $data = User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'city' => $request['city'],
          'password' => bcrypt($request['password']),
          'state' => $request['state'],
          'country' => $request['country'],
          'image' => $name,
          'created_by_admin'=> 1,
          "created_at" => carbon::now(),
                        ]);
  return $data;
//       $data = DB::table('users')->where('id', $request['id'])
//            ->update([
//                "name" => $request->input('name'),
//                 "email" => $request->input('email'),
//                "phone_number" => $request->input('phone_number'),
//                "state" => $request->input('state'),
//                "street_no" => $request->input('street_no'),
//                "city" => $request->input('city'),
//                "street_name" => $request->input('street_name'),
//                 "password" => $request->input('password'),
//                "zip_code" => $request->input('zip_code'),
//                "company_id" => $request->input('company_id'),
//                "created_date" => $request->input('created_date'),
//
//            ]);
       //dd($data);


    }


    public function savedata_admin($request){

         // dd('wasssss');

        if($files=$request->file('image')) {
            $name = $files->getClientOriginalName();
             $ext = $files->getClientOriginalExtension();
            $name = date('d_m_y') . '_' . time() . '_image.'.$ext;
            // $files->move(public_path('images\sucrai'), $name);
            $files->move(public_path('images/sucrai'), $name);
        }
        else{
          $name = 'abc.png';
        }
       
      $data = User::create([
          'name' => $request['name'],
          'email' => $request['email'],
          'city' => $request['city'],
          'password' => bcrypt($request['password']),
          'state' => $request['state'],
          'country' => $request['country'],
          'image' => $name,
          'user_role'=>1,
          'created_by_admin'=> 1,
          "created_at" => carbon::now(),
                        ]);
  return $data;
//       $data = DB::table('users')->where('id', $request['id'])
//            ->update([
//                "name" => $request->input('name'),
//                 "email" => $request->input('email'),
//                "phone_number" => $request->input('phone_number'),
//                "state" => $request->input('state'),
//                "street_no" => $request->input('street_no'),
//                "city" => $request->input('city'),
//                "street_name" => $request->input('street_name'),
//                 "password" => $request->input('password'),
//                "zip_code" => $request->input('zip_code'),
//                "company_id" => $request->input('company_id'),
//                "created_date" => $request->input('created_date'),
//
//            ]);
       //dd($data);


    }

	public function loginSecurity()
	{
		return $this->hasOne('App\LoginSecurity');
	}

}
