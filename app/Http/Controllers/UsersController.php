<?php

namespace App\Http\Controllers;

use Faker\Provider\Company;
use Illuminate\Http\Request;
use App\User;
use Session;
use App\Mail\Notifications;
use Mail;
use Auth;
use Lang;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Support\Facades\Validator;

use App\Imports\ProjectsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('AdminAccess');
        $this->user=$user;
    }
    public function site_admin_index(){
      // dd(auth()->user()->user_role);
      if(auth()->user()->user_role != '1'){
        return redirect()->back();
      }
           $data = DB::table('users')->where('user_role',1)->where('id' , '!=' ,auth()->user()->id )->get();
           return view('admin.users.siteadmin_home', compact("data"));
    }
    public function make_user_site_admin(Request $request)
	{
      
      DB::table('users')->where('id',$request->id)->update([
        'user_role' => 1,
      ]);
      return DB::table('users')->where('id' , $request->id)->pluck('name')->first();
    }
    public function site_admin_edit($id)
	{
       if(auth()->user()->user_role != 1){
        return redirect()->back();
      }
        $data=$this->user->editUser($id);
        $user = $data[0];
        $tribe = $data[1];
        return view('admin.users.edit_admin', compact("user","tribe"));
    }
    public function site_admin_create()
	{
       if(auth()->user()->user_role != 1){
        return redirect()->back();
      }
      // dd('wallaakakak');
      $companies = '';
       return view('admin.users.admin_add', compact("companies"));
    }
    public function pages_create()
	{
       if(auth()->user()->user_role != 1){
        return redirect()->back();
      }
      $data = DB::table('pages')->first();
      // dd($data);
      return view('admin.pages.pages' , compact('data'));


    }
    public function pages_update(Request $request)
	{
      // dd($request->all());
      if($request->page_id){
        DB::table('pages')->where('id' , $request->page_id)->update([
             'privacy_policy' =>  $request->privace_policy,
             'terms_of_user'=>    $request->terms_of_user,
        ]);
    }
    else{
        DB::table('pages')->insert([
           'privacy_policy' =>  $request->privace_policy,
           'terms_of_user'=>    $request->terms_of_user,
      ]);

    }

       Session::flash('success', 'Successfully updated Pages');
                return redirect("pages");
    }
    public function site_admin_store(Request $request)
	{
      // dd('yess');
          $this->validate($request, [
          'image' => 'mimes:jpeg,png',
      ],
          $messages = [
              'required' => 'The Image:attribute field is required.',
              'mimes' =>    'Only jpeg,  are allowed.'
          ]
      );


        $flag = DB::table('users')->where('email', $request->email)->first();
        if($flag){
                Session::flash('Fail', 'Email already exists');
                return redirect("site_admin");
        }
        // $data=$this->user->savedata($request);
        $data=$this->user->savedata_admin($request);


        if($data){
                Session::flash('success', Lang::get('general.success_message'));
                return redirect("site_admin");
        }
        else{
                Session::flash('Fail', 'Some Thing Went Wrong');
                return redirect("site_admin");

        }
    }
    public function site_admin_update(Request $request)
    {
        
        // dd($request);
                                 $this->validate($request, [
                                'image' => 'mimes:jpeg,png',
                                ],
                                    $messages = [
                                        'required' => 'The Image:attribute field is required.',
                                        'mimes' => 'Only jpeg, png, are allowed.'
                                    ]
                                );
                                   
        $data=$this->user->updatedata($request);

        if($data){
                Session::flash('success', Lang::get('general.success_message'));
                return redirect("site_admin");
        }
        else{
            Session::flash('Fail', 'Some Thing Went Wrong');
            return redirect("site_admin");
        }
    }

    public function index()
    {
        $users=$this->user->indexUser();
        // dd($users->all());
        // $user_id = Auth::user()->id;
//        dd($users);
          foreach ($users as $user) {
                    if(count($user->tribe) >0){
                                foreach($user->tribe as $tribe){
                                    
                                    $topic_ids = DB::table('topics')->where('tribe_id' , $tribe->id)->pluck('id');
                                    // $topic_points = DB::table('topics')->where('tribe_id' , $tribe->id)->select('id');
                                    $question = DB::table('question_answers')->wherein('topic_id' , $topic_ids)->pluck('id');
                                    $answered_questions = DB::table('user_questions')->where('user_id' , $user->id)->wherein('question_answer_id' , $question)->get();

                                    if(count($answered_questions)>0){
                                           $tribe->total_answered_question = count($answered_questions);
                                    }
                                    else{
                                        $tribe->total_answered_question = 0;
                                    }

                                }
                }
          }
          // dd($users);

        return view('admin.users.home', compact("users"));
    }

    

    public function edit($id)
    {
        
        $data=$this->user->editUser($id);
        
	
	$user = $data[0];
    if($user){   
$tribe = $data[1];
        return view('admin.users.edit', compact("user","tribe"));
}else{
return redirect("users");
}
    }

    public function create()
    {

        
        $companies = '';
        return view('admin.users.add', compact("companies"));
    }


    public function update(Request $request)
    {
        
//         dd($request->all());
                                 $this->validate($request, [
                                'image' => 'mimes:jpeg,png',
                                ],
                                    $messages = [
                                        'required' => 'The Image:attribute field is required.',
                                        'mimes' => 'Only jpeg, png, are allowed.'
                                    ]
                                );
      $limit_check = DB::table('user_tribes')->where('tribe_id' , $request->tribe_id)->pluck('user_id')->count();
      if($limit_check >= 150){
            Session::flash('Fail', 'Maximum users have already joined this group');
            return redirect("users");
      }                                 
       
//echo '<pre>';print_r($_FILES);
//echo '<pre>';print_r($request->file('image'));
//echo $request->file('image');
//echo '<pre>';print_r($_POST);
//echo $request->name;
//exit;
      $imgname = '';
if ($request->hasfile('image')) {
  $file = $request->file('image');
 // echo public_path();exit;
                  $filename = str_replace(' ', '', $file->getClientOriginalName());
                  $ext = $file->getClientOriginalExtension();
                  $imgname = uniqid() . $filename;
                  $destinationpath = public_path('images/sucrai');
                  $file->move($destinationpath, $imgname);

}
if($imgname==''){
  $data = DB::table('users')->where('id',$request->id)->update([
        'name' => $request->name,
'is_blocked' => $request->is_blocked,
'is_email_varified' => $request->is_email_varified,
        'email' => $request->email,
       
      ]);


}else{
  $data = DB::table('users')->where('id',$request->id)->update([
        'name' => $request->name,
'is_blocked' => $request->is_blocked,
'is_email_varified' => $request->is_email_varified,
        'email' => $request->email,
        'image' => $imgname,
      ]);


}          

if($request->confirm_password!='' && $request->password!=''){

if($request->password!=$request->confirm_password){
    Session::flash('Fail', 'Password and Confirm Password must be same.');
            return redirect("users");
}
if($request->password==$request->confirm_password && $request->password!=''){







//$res = validatePassword($request->password);




$pass = $request->password;
$errors = array();
$res = '';
if (strlen($pass) < 12 || strlen($pass) > 30) {
    $errors[] = "Password should be min 12 characters and max 30 characters";
}
if (!preg_match("/\d/", $pass)) {
      $errors[] = "Password should contain at least one digit";
}
if (!preg_match("/[A-Z]/", $pass)) {
     $errors[] = "Password should contain at least one Capital Letter";
}
if (!preg_match("/[a-z]/", $pass)) {
     $errors[] = "Password should contain at least one small Letter";
}
if (!preg_match("/\W/", $pass)) {
     $errors[] = "Password should contain at least one special character";
}
if (preg_match("/\s/", $pass)) {
     $errors[] = "Password should not contain any white space";
}


if(sizeof($errors)==0){
    $res = 'success';
}





        if($res!='success'){
         Session::flash('errors', $errors);
         return redirect("users/".'edit/'.$request->id);
        }

    DB::table('users')->where('id',$request->id)->update([

            'password'=> Hash::make($request->password)
           
        ]);

}


}
         



       //$data=$this->user->updatedata($request);

        if($data){
                Session::flash('success', Lang::get('general.success_message'));
                return redirect("users");
        }
        else{
            //Session::flash('Fail', 'Some Thing Went Wrong');
            return redirect("users");
        }
    }


    public function store(Request $request)
    {
   
      // dd($request);
       $this->validate($request, [
        'image' => 'mimes:jpeg,png',
    ],
        $messages = [
            'required' => 'The Image:attribute field is required.',
            'mimes' => 'Only jpeg,  are allowed.'
        ]
    );


        $flag = DB::table('users')->where('email', $request->email)->first();
        if($flag){
                Session::flash('Fail', 'Email already exists');
                return redirect("users");
        }






$pass = $request->password;
$errors = array();
$res = '';
if (strlen($pass) < 12 || strlen($pass) > 30) {
    $errors[] = "Password should be min 12 characters and max 30 characters";
}
if (!preg_match("/\d/", $pass)) {
      $errors[] = "Password should contain at least one digit";
}
if (!preg_match("/[A-Z]/", $pass)) {
     $errors[] = "Password should contain at least one Capital Letter";
}
if (!preg_match("/[a-z]/", $pass)) {
     $errors[] = "Password should contain at least one small Letter";
}
if (!preg_match("/\W/", $pass)) {
     $errors[] = "Password should contain at least one special character";
}
if (preg_match("/\s/", $pass)) {
     $errors[] = "Password should not contain any white space";
}


if(sizeof($errors)==0){
    $res = 'success';
}




 if($res!='success')
        {
            Session::flash('errors', $errors);
        

return redirect("users/add");
}








        $data=$this->user->savedata($request);


        if($data){
                Session::flash('success', Lang::get('general.success_message'));
                return redirect("users");
        }
        else{
                Session::flash('Fail', 'Some Thing Went Wrong');
                return redirect("users");

        }

    }
   
    public function destroy(Request $request)
    {
//        dd($request);
//        $id = $request->input("id");
//
//        DB::table('freecomps')->where('user_id',$id)->delete();
//
//        DB::table('users')->where('id',$id)->delete();

        //soft delete code
  $id = $request->input("id");
        User::where("id", $id)->delete();
        DB::table('user_tribes')->where('user_id' , '=' , $id )->delete();
        DB::table('user_questions')->where('user_id' , $id)->delete();
        DB::table('tribes')->where('leader' ,'=', $id)->update([
           'leader' => 0,
        ]);

    }




 


    public function login_user(Request $request, $id){
        Auth::logout();
        Auth::loginUsingId($id, true);
        return redirect('/');
    }



  

    /**
     * Show import sceen
     */
    public function getImport()
    {
        return View('admin/users/import');
    }
    // import users
    public function importUsers(Request $request)
    {

           request()->validate([
            'file' => 'required|mimes:xls'
        ]);
        // $this->validate($request, array(
        //     'file'   => 'max:10240|required|mimes:csv,xlsx',
        // ));

        // $path = request()->file('file')->getRealPath();

         $path = request()->file('file')->getRealPath();
         $path1 = request()->file('file')->store('temp'); 
         $path=storage_path('app').'/'.$path1; 

        // $customerArr = $this->csvToArray($path);
        // dd($path);
        $customerArr =  Excel::toArray(new ProjectsImport, $path);
        // dd($customerArr[0]);


            // (new ProjectsImport)->import($fil

       // $csvArrr =  Excel::import(\Maatwebsite\Excel\Concerns\ToModel,$path);
        // dd($csvArrr);
            $customerArr = $customerArr[0];
              $ses_err_message = "";
              $imported_user_count = 0;
            $missing_entry_check = 'true';
            $sec_check = 'false';   

            // $eml = 'abcabac@gmail.com';
             
            
           


            $indexes = array_keys($customerArr[0]);
            // dd($indexes);


            if(  ($indexes[0] != 'serial') )
            {

                 $sec_check = 'true';
                 $missing_entry_check = 'false';
            }

             if(  ($indexes[1] != 'name') )
            {

                   $sec_check = 'true';
                   $missing_entry_check = 'false';
            }

             if(  ($indexes[2] != 'email') )
            {

                   $sec_check = 'true';
                   $missing_entry_check = 'false';
            }


             if(  ($indexes[3] != 'password') )
            {
                   $sec_check = 'true';
                   $missing_entry_check = 'false';
            }

            


            if( $sec_check == 'true'){
                $missing_entry_check = 'false';
            }


            if($missing_entry_check == 'false'){
                  $ses_err_message.= 'please provide proper header fields in EXCEL file to import Users, Or <a href="'. url('/users/csv/sample') . '"> click here  </a> to download sample XLS file;';
            }

        if( count($customerArr) > 0 )
        {
            foreach ($customerArr as $datum) {

                if($missing_entry_check == 'false'){
                    break;
                }

                   if( !isset($datum['serial']) ){
                     $ses_err_message.= 'serial field is undefined ; ';
                     continue;
                   }

                   if( !isset($datum['name']) ||    $datum['name'] == '' ){
                    $ses_err_message.= 'name field is undefined for serial # ' . $datum['serial'] .';' ;
                    continue;
                   }

                   if( !isset($datum['email'])    ||    $datum['email'] == ''    ){
                   $ses_err_message.= 'email field is undefined for serial # ' . $datum['serial'].';';
                    continue;
                   }

                   if( !isset($datum['password'])   ||    $datum['password'] == ''    ){
                   $ses_err_message.= 'password field is undefined for serial # ' . $datum['serial'].';';
                    continue;
                   }
                if(!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $datum['email'])){
                    $ses_err_message.= 'Please provide proper email at serial # ' . $datum['serial'].';';
                    continue;

               }
                if (!Db::table('users')->where('email', '=', $datum['email'])->first())
                {


                    $data = array(
                                    'name' => $datum['name'],
                                    'email' => $datum['email'],
                                    'password' => bcrypt($datum['password']),
                                    'created_by_admin'=> 1,
                                    'image'=>'abc.png'
                                 );
                   $rr =  DB::table('users')->insert($data);

                     if($rr){
                        $imported_user_count++;
                    }
                }
                else{
                     $ses_err_message.= 'Email already exists at serial # ' . $datum['serial'].';';
                }
            }
        }
        // print "<pre>";
        // print_r($customerArr);

        // Session::flash('success',  'Successfully Imported Users!');
        if($imported_user_count > 0){
         $ses_err_message.= $imported_user_count.' Users imported successfully ;';
        }
        else{
             $ses_err_message.= 'no record imported ;';
        }
        Session::flash('question_import_error',  $ses_err_message);
        return redirect("users/import");


    }

    private function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }

    
 public function update_password($user_id){


        $user = DB::table('users')->where('id',$user_id)->first();
        return view('admin.users.update_password' , compact('user'));
     
    }
    public function update_password_post(Request $request){





if($request->password==$request->confirm_password && $request->password!=''){
        
       // $res = validatePassword($request->password);
$pass = $request->password;
$errors = array();
$res = '';
if (strlen($pass) < 12 || strlen($pass) > 30) {
    $errors[] = "Password should be min 12 characters and max 30 characters";
}
if (!preg_match("/\d/", $pass)) {
      $errors[] = "Password should contain at least one digit";
}
if (!preg_match("/[A-Z]/", $pass)) {
     $errors[] = "Password should contain at least one Capital Letter";
}
if (!preg_match("/[a-z]/", $pass)) {
     $errors[] = "Password should contain at least one small Letter";
}
if (!preg_match("/\W/", $pass)) {
     $errors[] = "Password should contain at least one special character";
}
if (preg_match("/\s/", $pass)) {
     $errors[] = "Password should not contain any white space";
}


if(sizeof($errors)==0){
    $res = 'success';
}







        if($res!='success')
        {
            Session::flash('errors', $errors);
        

return redirect()->back();
}
        DB::table('users')->where('id',$request->id)->update([

            'password'=> Hash::make($request->password)
           
        ]);

        Session::flash('success', 'Successfully updated password');


    }else{

    }
    

    


    



        return back();
    }

    public function update_profile($user_id){

       $user = $user = DB::table('users')->where('id',$user_id)->first();
        return view ('admin.users.update_profile', compact('user'));
    }




    public function update_profile_admin(Request $request){
        $id = $request->id;
        $user = DB::table('users')->where('id',$request->id)->first();
        
        /*if ($request->hasFile('upload_file')) {

             $destination = '/assets/img'.$user->image;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $image = $request->file('upload_file');
            $fileName = date('dmY') . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path("/assets/img"), $fileName);
            $image->image = $fileName;
        }*/

if ($request->hasfile('image')) {
  $file = $request->file('image');
 // echo public_path();exit;
                  $filename = str_replace(' ', '', $file->getClientOriginalName());
                  $ext = $file->getClientOriginalExtension();
                  $imgname = uniqid() . $filename;
                  $destinationpath = public_path('images/sucrai');
                  $file->move($destinationpath, $imgname);

}


















        DB::table('users')->where('id',$id)->update([

        
        'name'=>$request->name,
        'image'=>$imgname,
        'email'=>$request->email

        ]);
          return back();
    }




public function validatePassword($pass){
    $errors = array();
if (strlen($pass) < 12 || strlen($pass) > 30) {
   return $errors[] = "Password should be min 12 characters and max 30 characters";
}
if (!preg_match("/\d/", $pass)) {
     return $errors[] = "Password should contain at least one digit";
}
if (!preg_match("/[A-Z]/", $pass)) {
    return $errors[] = "Password should contain at least one Capital Letter";
}
if (!preg_match("/[a-z]/", $pass)) {
    return $errors[] = "Password should contain at least one small Letter";
}
if (!preg_match("/\W/", $pass)) {
    return $errors[] = "Password should contain at least one special character";
}
if (preg_match("/\s/", $pass)) {
    return $errors[] = "Password should not contain any white space";
}

return 'success';

  }

  public 
function randomPasswordGenerator()
{

    $password = '';
    $passwordSets = ['1234567890', '%^&@*#(){}', 'ABCDEFGHJKLMNPQRSTUVWXYZ', 'abcdefghjkmnpqrstuvwxyz'];

    //Get random character from the array
    foreach ($passwordSets as $passwordSet) {
        $password .= $passwordSet[array_rand(str_split($passwordSet))];
    }

    // 6 is the length of password we want
    while (strlen($password) <= 12) {
        $randomSet = $passwordSets[array_rand($passwordSets)];
        $password .= $randomSet[array_rand(str_split($randomSet))];
    }
    echo $password;
}


}
