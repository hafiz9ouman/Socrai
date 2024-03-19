<?php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Models\User;
use App\User;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use DB;
use Swift_Mailer;
use Swift_SmtpTransport;
use Swift_Attachment;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
 public function email_test2(){
    $user = DB::table('users')->where('email','test@test.com')->first();
    //echo '<pre>';print_r($user);exit;
        
        $new_pas = rand(10000000,99999999);
        $name = 'Qaiser Mahmood';
        $email = 'stepinnsolution@gmail.com';

        /*from swift mailer*/
// $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
//                 $transport->setUsername(env('mail_username'));
//                 $transport->setPassword(env('MAIL_PASSWORD'));
//                 // echo '11dddd';exit;

//                 $swift_mailer = new Swift_Mailer($transport);
                // Mail::setSwiftMailer($swift_mailer);
                $data = ["name" => $name ,"password" => $new_pas , "email"=>$email];
                 $reciever_email = $email;
                 $sender_email = env('MAIL_FROM_ADDRESS');
                 $subject = 'Socrai Notification: Account password is reset';

                Mail::send(['html'=>'emails.forgot_password'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
                    $message->to($reciever_email, 'Password Recovery')->subject
                    ($subject);
                    $message->from($sender_email,$sender_email);
                });


/*from swift mailer*/

    //echo 'permissions test....';
 }
    public function login()
    {
          // \Artisan::call('config:clear');
          // \Artisan::call('cache:clear');
         
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $token=$user->createToken('MyApp')->accessToken;
            $change_password_popup_cehck=0;
                   if($user->created_by_admin == 1){
                    $change_password_popup_cehck = 1;
                   }
                   $label = '';
                   $can_Delete = '0';
                  
                  if($user->is_leader == 1){
                    $can_Delete = '1';
                    $label = ' SOCRAI Tribe Leader ';
                  }
                  if($user->user_role == 2){
                    $can_Delete='1';
                    $label = ' SOCRAI Leader';
                  }
                  if($user->user_role == 1){
                    $can_Delete = '1';
                    $label = 'SOCRAI Web Admin ';
                  }
                  

                  if($can_Delete == '0'){
                       $label = 'SOCRAI User';
                  }

                 
                  


            // $token =  $user->createToken('MyApp')->accessToken;
            // $token =  '';
            $userData = array();
            $userData['id'] = $user->id;
            $userData['name'] = $user->name;
            $userData['email'] = $user->email;
            $userData['image'] = $user->image;
            $userData['role'] = $user->user_role;
            $userData['is_leader'] = $user->is_leader;
            $userData['change_password_popup_cehck'] = $change_password_popup_cehck;
            $userData['email_varified'] = $user->is_email_varified;
            $userData['can_delete'] = $can_Delete;
            $userData['identity_label']=$label;
             
            if($user->is_email_varified==0){
                $name = $user->name;
                $email = $user->email;
                $new_pas = rand(1000,9999);
                DB::table('users')->where('email', $email)->update([
                    "varif_code" =>$new_pas,
                    ]);
                /*from swift mailer*/
            //   $transport = new Swift_SmtpTransport('smtp.office365.com', 587, 'tls');
            //     $transport->setUsername('noreply@d3cod.com');
            //     $transport->setPassword('Str0ngFunguz0!');
            //     // echo '11dddd';exit;
            //     $swift_mailer = new Swift_Mailer($transport);
            //     Mail::setSwiftMailer($swift_mailer);
            //     $data = ["name" => $name ,"password" => $new_pas , "email"=>$email];
            //      $reciever_email = $email;
            //      $sender_email = 'noreply@d3cod.com';
            //      $subject = 'Socrai Notification: Email Verification Code';

            //     Mail::send(['html'=>'emails.signup'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
            //         $message->to($reciever_email, 'Email Verification')->subject
            //         ($subject);
            //         $message->from($sender_email,$sender_email);
            //     });

            $data = ["name" => $name, "password" => $new_pas, "email" => $email];
            $receiver_email = $email;
            $sender_email = 'noreply@socrai.com';
            $subject = 'Socrai Notification: Email Verification Code';

            Mail::send(['html' => 'emails.signup'], $data, function ($message) use ($receiver_email, $sender_email, $subject) {
                $message->to($receiver_email, 'Email Verification')->subject($subject);
                $message->from($sender_email, 'Socrai'); // Use your sender name here
            });



            /*from swift mailer*/

                    


                    return response()->json(
                        [
                            'code' => '401',
                        
                            'message' => "Your email address is not verified.",
                            
                        ],
                    401
                    );






            }
           


            return response()->json(
                [
                    'code' => '200',
                    'user' => $userData,
                    // 'tokken' => $token,
                    'message' => "success",
                    'tokken'=>$token,
                    'base_url_of_folder'=> '/public/images/sucrai/',
                ],
                $this->successStatus
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'error_description' => array('error' => array('Invalid credentials..')),
                    'message' => '',
                ],
                403
            );
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */


    

     public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => '400',
                    'error_description' => $validator->errors(),
                    'message' => '',
                ],
                403
            );
        }

$input = $validator->validated();


$pass = $input['password'];
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


 if ($res!='success') {
            return response()->json(
                [
                    'code' => '400',
                    'error_description' => $errors,
                    'message' => '',
                ],
                403
            );
        }



        $input['password'] = bcrypt($input['password']);
        $new_user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password']
        ]);
        $token=$new_user->createToken('MyApp')->accessToken;
        
    $new_pas = rand(1000,9999);
               DB::table('users')->where('email',$input['email'])->update([
                   "varif_code" =>$new_pas,
                   ]);
               $name = DB::table('users')->where('email',$input['email'])->pluck('name')->first();
               $email = $input['email'];
            //    $email_data = array('new_pas' => $new_pas , 'name' => $name);
            $email_data = [
                'new_pas' => $new_pas,
                'name' => $name,
            ];

            $data = ["name" => $name, "password" => $new_pas, "email" => $email];
            $receiver_email = $email;
            $sender_email = 'noreply@socrai.com';
            $subject = 'Socrai Notification: Email Verification Code';

            Mail::send(['html' => 'emails.signup'], $data, function ($message) use ($receiver_email, $sender_email, $subject) {
                $message->to($receiver_email, 'Email Verification')->subject($subject);
                $message->from($sender_email, 'Socrai'); // Use your sender name here
            });


// /*from swift mailer*/
            //    $transport = new Swift_SmtpTransport(env('smtp.office365.com'), env('587'), env('tls'));
            //     $transport->setUsername(env('noreply@d3cod.com'));
            //     $transport->setPassword(env('Str0ngFunguz0!'));
            //     // echo '11dddd';exit;
            //     $swift_mailer = new Swift_Mailer($transport);
            //     Mail::setSwiftMailer($swift_mailer);
        //         $to_name = 'Test User';
        // $to_email = 'stepinnsolution@gmail.com'; //'smalltime59@yahoo.com';
        // $data = array([
        //     "products" => '',
        //     "eyesdata" => '',
            
        // ]);
        // $from = 'noreply@socrai.com';
        
        // Mail::send('emails.sendmail', $data[0], function ($message) use ($to_name, $to_email,$from) {
        //     $message->to($to_email, $to_name)
        //         ->subject('Subject');
        //     $message->from($from, 'mine');
        // });
		
               
/*from swift mailer*/

// $to_name = 'Test User';
//         $to_email = $email; //'smalltime59@yahoo.com';
//         $from = 'office@ochelarii.ro';
       
//             $from = 'noreply@d3cod.com';
//        }
//         Mail::send('emails.sendmail', $email_data, function ($message) use ($to_name, $to_email,$from) {
//             $message->to($to_email, $to_name)
//                 ->subject('Test email');
//             $message->from($from, "Simple lable testing");
//         });

// $to = $email;
// $subject = "Socrai Email Verification";
// $txt = "Hello world!";
// $headers = "From: info@socrai.com" . "\r\n" .
// "CC: info@socrai.com";

// mail($to,$subject,$txt,$headers);








           /*     $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                $from = 'noreply@socrai.com'; 
                $fromName = 'SOCRAI'; 
               
                $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
               

            mail($email, 'Socrai Notification: Email Verification Code', $message, $headers);
*/

        return response()->json(
            [
                'code' => '200',
                'message' => "Varification code sent to your email please check your inbox.",
                // 'message' => "Account Successfully Created",
                'data' => $new_user,
                'token'=>$token,

            ],
            $this->successStatus
        );
    }

    public function resend_code(Request $request){



        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => '400',
                    'error_description' => $validator->errors(),
                    'message' => '',
                ],
                403
            );
        }

            $user = DB::table('users')->where('email' , $request->email)->first();
            if($user){
                   $new_pas = rand(1000,9999);
    // $passwordSets = ['1234567890', '%^&@*#(){}', 'ABCDEFGHJKLMNPQRSTUVWXYZ', 'abcdefghjkmnpqrstuvwxyz'];

    // //Get random character from the array
    // foreach ($passwordSets as $passwordSet) {
    //     $new_pas .= $passwordSet[array_rand(str_split($passwordSet))];
    // }

    // // 6 is the length of password we want
    // while (strlen($new_pas) <= 12) {
    //     $randomSet = $passwordSets[array_rand($passwordSets)];
    //     $new_pas .= $randomSet[array_rand(str_split($randomSet))];
    // }
                   DB::table('users')->where('email',$request->email)->update([
                       "varif_code" =>$new_pas,
                       ]);
                   $name = DB::table('users')->where('email',$request->email)->pluck('name')->first();
                   $email = $request->email;
                   $email_data = array('new_pas' => $new_pas , 'name' => $name);
                                    
                    //$email_data = array('description' => $inputs['title'] . ' Updated.');


                /*$message = '<html><body>';
                $message .= '<img style="background:black;" src="https://app.socrai.com/sucrai/assets/images/logo.png" alt="Website Change Request" />';
                $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
                $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";


                    $message .= "<tr><td><strong>Message :</strong> </td><td>Varification code is " . strip_tags( $new_pas) . "</td></tr>";

               
                $message .= "</table>";
                $message .= "</body></html>";*/





/*from swift mailer*/
// $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
//                 $transport->setUsername(env('mail_username'));
//                 $transport->setPassword(env('MAIL_PASSWORD'));
//                 // echo '11dddd';exit;

//                 $swift_mailer = new Swift_Mailer($transport);
//                 Mail::setSwiftMailer($swift_mailer);
                $data = ["name" => $name ,"password" => $new_pas , "email"=>$email];
                 $reciever_email = $email;
                 $sender_email = 'noreply@socrai.com';
                 $subject = 'Socrai Notification: Email Verification Code';

                Mail::send(['html'=>'emails.signup'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
                    $message->to($reciever_email, 'Email Verification Code')->subject
                    ($subject);
                    $message->from($sender_email,$sender_email);
                });


/*from swift mailer*/






                /*$headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                $from = 'noreply@socrai.com'; 
                $fromName = 'SOCRAI'; 
                // Additional headers 
                $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
                $headers .= 'Cc: woder@socrai.com' . "\r\n"; 
               

                mail($email, 'Socrai Notification: Email Verification Code', $message, $headers);*/
                   






                    return response()->json(['message' => 'Verification Code sent' , 'status' =>'success' , 'code' => 200 ], 200);
  

            }
            else{
               return response()->json(['message' => 'User not found!' , 'status' =>'error' ], 404);
            }

    }


    public function varify_code(Request $request){

           $validator = Validator::make($request->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => '400',
                    'error_description' => $validator->errors(),
                    'message' => '',
                ],
                403
            );
        }

           $user = DB::table('users')->where('email' , $request->email)->first();
           if($user){
                                if($user->varif_code == $request->code){
                                      $check = DB::table('users')->where('email' , $user->email)->update(['is_email_varified' => 1,]);
                                                     return response()->json(
                                                           [
                                                           'code' => '200',
                                                           'message' => 'email varified',
                                                           'email_varified' => 1,
                                                           'data' => DB::table('users')->where('email' , $request->email)->select('name' , 'email' , 'is_email_varified','id')->first(),
                                                                      ],
                                                                          200
                                                                           );
                                }
                                else{
                                                        return response()->json(
                                                           [
                                                           'code' => '200',
                                                           'message' => 'code did not matched',
                                                           'email_varified' => 0,
                                                            ],
                                                                          200
                                                                           );
                                }
           }
           else{
                                                           return response()->json(
                                                           [
                                                           'code' => '403',
                                                           'message' => 'User not found',
                                                           'email_varified' => 0,
                                                            ],
                                                                          403
                                                                           );
           }         


    }
    /**
     * Display LoggedIn User details api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    /**
     * Get user by id.
     */
    public function show(Request $request, $userId)
    {
        $user = User::find($userId);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found!'], 404);
    }

    public function forgot(Request $request)
    { 
         

        $input = $request->all();
        // dd($input);
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array()); }



   else{

           $user = DB::table('users')->where('email',$input['email'])->first();
           if($user == null){
               return response()->json(
                [
                    'code' => '422',
                    'error_description' => 'No Email Found',
                    'message' => '',
                ],
                422
            );      
            //   return response()->json(
            //     [
            //         'code' => '200',
            //         'message' => 'New Password Successfully Sent, Check Your e-mail',
                   
            //     ],
            //     200
            // );        
 

           }
           else{
               $cehck_email_sent = true;
               $error_message = null;
               $new_pas = '';
           $passwordSets = ['1234567890', '%^&@*#(){}', 'ABCDEFGHJKLMNPQRSTUVWXYZ', 'abcdefghjkmnpqrstuvwxyz'];

    //Get random character from the array
    foreach ($passwordSets as $passwordSet) {
        $new_pas .= $passwordSet[array_rand(str_split($passwordSet))];
    }

    // 6 is the length of password we want
    while (strlen($new_pas) <= 12) {
        $randomSet = $passwordSets[array_rand($passwordSets)];
        $new_pas .= $randomSet[array_rand(str_split($randomSet))];
    }
               $previous_pass = $user->password;
               DB::table('users')->where('email',$input['email'])->update([
                   "password" => bcrypt($new_pas)
                   ]);
               $name = DB::table('users')->where('email',$input['email'])->pluck('name')->first();
               $email = $input['email'];
               $email_data = array('new_pas' => $new_pas , 'name' => $name);
                                
                //$email_data = array('description' => $inputs['title'] . ' Updated.');


               try{
                      


/*from swift mailer*/
// $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
//                 $transport->setUsername(env('mail_username'));
//                 $transport->setPassword(env('MAIL_PASSWORD'));
//                 // echo '11dddd';exit;
//                 $swift_mailer = new Swift_Mailer($transport);
//                 Mail::setSwiftMailer($swift_mailer);
                $data = ["name" => $name ,"password" => $new_pas , "email"=>$email];
                 $reciever_email = $email;
                 $sender_email = 'noreply@socrai.com';
                 $subject = 'Socrai Notification: Account password is reset';

                Mail::send(['html'=>'emails.forgot_password'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
                    $message->to($reciever_email, 'Password Recovery')->subject
                    ($subject);
                    $message->from($sender_email,$sender_email);
                });


/*from swift mailer*/










                /*$headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                $from = env('MAIL_FROM_ADDRESS'); 
                $fromName = env('MAIL_FROM_NAME'); 
                $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
                
            mail($email, 'Socrai Notification: Account password is reset', $message, $headers);*/
                
                }
      catch(\Exception $e){
           $cehck_email_sent = false;
           $error_message = $e->getMessage();
      }

               if($cehck_email_sent == false){
                    DB::table('users')->where('email',$input['email'])->update([
                           "password" => $previous_pass,
                           ]);
                     return response()->json(
                                          [
                                              'code' => '200',
                                              'message' => 'Woops! unable to send email, please try again later'
                                          ],
                                          200
                                            ); 
               }else{
                  return response()->json(
                                          [
                                              'code' => '200',
                                              'message' => 'New Password Successfully Sent, Check Your e-mail',
                                             
                                          ],
                                          200
            ); 
               }

                // dd('not in if  ');

                 
           }
       }
       
       // return redirect()->back()->with('alert','Something Wrong');
        // } else {
        //     try {
        //         $response = Password::sendResetLink($request->only('email'), function (Message $message) {
        //             $message->subject($this->getEmailSubject());
        //         });
        //         switch ($response) {
        //             case Password::RESET_LINK_SENT:
        //                 return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
        //             case Password::INVALID_USER:
        //                 return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
        //         }
        //     } catch (\Swift_TransportException $ex) {
        //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        //     } catch (Exception $ex) {
        //         $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
        //     }
        // }
        // return \Response::json($arr);
    }
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


    public function updateProfile(Request $request)
    {    
        // dd($request->all());
        // print_r($request->all()); exit;
        // echo $user_id;
        // exit;
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];
        
        // Check if 'image' field exists in the request
        if ($request->file('image')) {
            $rules['image'] = 'image|mimes:jpeg,png,jpg,gif|max:2048';
        }
        
        $validator = Validator::make($request->all(), $rules);
        

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'email' => 'required|email',
        //     'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add image validation rules here
        // ]);
    
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => '422',
                    'error_description' => array('error' => $validator->errors()),
                    'message' => '',
                ],
                422
            );
        }

        if($files=$request->file('image')) {
            $extension = $files->getClientOriginalExtension();
            $allowedExt = ['jpg', 'jpeg', 'gif', 'png'];
            if (!in_array($extension, $allowedExt)){
                return response()->json(
                    [
                        'code' => '403',
                        'message' => "Something`s Wrong",
                    ],
                    403
                );
            }
            $name = time()."_".$files->getClientOriginalName();
             // time().'.'.$request->image->getClientOriginalExtension();
            // $files->move(public_path('images\sucrai'), $name);
            $files->move(public_path('images/sucrai'), $name);
        }
        
        $input = $request->all();

        if(!empty($input['password'])){
                   if( empty($input['con_password'])){
                     return response()->json(
                    [
                        'code' => '422',
                        'error_description' => array('error' => "confirm password field is required"),
                        'message' => '',
                    ],
                    422
                );
                   }

                   //  if($user->created_by_admin == 1){
                   //  $change_password_popup_cehck = 1;
                   // }
                   // $loged_in_user = DB::table('users')->where('id' , auth('api')->user()->id)->first();
                   // if()



        }
       
        $usercheck=Auth::user();
        $user = User::find($usercheck->id);
        if(!$user)
        {
              return response()->json(
                [
                       'message'=>'user not found',
                ]
                );
        }
        if ($user->email != $input['email']) {  // if user entered email and db email is not same.
            // check if email is not unique.
            if (User::where('email', '=', $input['email'])->exists()) {
                // email already exists.
                return response()->json(
                    [
                        'code' => '422',
                        'error_description' => array('error' => "email already registered."),
                        'message' => '',
                    ],
                    422
                );
            }
        }

        $user->name = $input['name'];
        $user->email = $input['email'];
        if (isset($input['password']) && !empty($input['password'])) {
            if($input['password'] != $input['con_password']){
                return response()->json(
                    [
                        'code' => '422',
                        'error_description' => array('error' => "password does not match."),
                        'message' => '',
                    ],
                    422
                );
            }
            $user->password = bcrypt($input['password']);
            $user->created_by_admin = 0;
        }
        if($files=$request->file('image')) { 
            $user->image = $name;
        }
        $user->save();



        return response()->json(
            [
                'code' => '200',
                'message' => "success"
            ],
            $this->successStatus
        );
    }
    /**
     * Get user by user_id.
     */
    public function getUser()
    {
        $check=Auth::user();
        $user = User::find($check->id);
        if ($user) {
            $userdata = array();
            $userdata['id'] = $user->id;
            $userdata['name'] = $user->name;
            $userdata['email'] = $user->email;
            $userdata['image'] = $user->image;
            $userdata['created_at'] = $user->created_at;
            $userdata['updated_at'] = $user->updated_at;
            // $userdata['']
            return response()->json(
                [
                    'code' => '200',
                    'image_base_url_folder' =>'/public/images/sucrai/',
                    'message' => $userdata,
                ],
                200
            );
        }
        return response()->json(
            [
                'code' => '404',

                'error_description' => array('error' => "user_id not found"),
                'message' => '',
            ],
            404
        );
    }
    /**
     *  User Logout
     */
    public function logout(Request $request)
    {
        
            $user=Auth::user();
            if($user)
            {
                $user->token()->revoke();
                return response()->json(
                    [
                           'code'=>200,
                           'message'=>'success',
                    ]
                    );
    

            }
            else
            {
                return response()->json(
                    [
                        'code' => '500',
                        // 'error_description' => array('error' => "Something Went Wrong."),
                        'message' => '',
                    ],500
                    );
    

            }

            


    }
    public function contact(Request $request)
    {   
        // dd($request);



        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'code' => '422',
                    'error_description' => array('error' => $validator->errors()),
                    'message' => '',
                ],
                422
            );
        }
        $input = $request->all();
        $name = $input['name'];
        $email = $input['email'];
        $message_ = $input['message'];
        // $to_name = 'Admin';
        $to_email = 'wonder@socrai.com';
        // $to_email = 'hafiz9oman.dev@gmail.com';
//$to_email = 'smalltime59@yahoo.com';

        $data = array(
            "name" => $name,
            "email" => $email,
            "message_" => $message_
        );
        


        try{


/*from swift mailer*/
// $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
//                 $transport->setUsername(env('mail_username'));
//                 $transport->setPassword(env('MAIL_PASSWORD'));
//                 // echo '11dddd';exit;
//                 $swift_mailer = new Swift_Mailer($transport);
//                 Mail::setSwiftMailer($swift_mailer);
                $data = ["name" => $name ,"email" => $email , "message_"=>$message_];
                 $reciever_email = $to_email;
                 $sender_email = 'noreply@socrai.com';
                 $subject = 'Socrai Notification: Contact inquiry';

                Mail::send(['html'=>'emails.contact'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
                    $message->to($reciever_email, 'Contact inquiry')->subject($subject);
                    $message->from($sender_email, 'Socrai');
                });


/*from swift mailer*/



/*
                $message = '<html><body>';
                $message .= '<img style="background:black;" src="https://app.socrai.com/sucrai/assets/images/logo.png" alt="Website Change Request" />';
                $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
                $message .= "<tr style='background: #eee;'><td><strong>User Name:</strong> </td><td>" . strip_tags($name) . "</td></tr>";
                $message .= "<tr><td><strong>User Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";


                    $message .= "<tr><td><strong>User Message:</strong> </td><td>" . strip_tags( $message_) . "</td></tr>";

                $message .= "</table>";
                $message .= "</body></html>";


                $headers = "MIME-Version: 1.0" . "\r\n"; 
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
                $from = 'noreply@socrai.com'; 
                $fromName = 'SOCRAI'; 
                
               $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 
                

mail($to_email,'Contact inquiry',$message,$headers);
*/

                }
      catch(\Exception $e){
         return response()->json(
            [
                'code' => '502',
                'message' => "Unable to send email, Please try again later"
            ],
            502
        );
      }
       
        return response()->json(
            [
                'code' => '200',
                'message' => "success"
            ],
            $this->successStatus
        );
    }
   public function privace_policy(){
    //echo 'asdfasfd';exit;
   $data =  DB::table('pages')->first();
   return response()->json(
                [
                    'code' => '200',
                    'message' => 'success',
                    'data' => $data->privacy_policy
                    // 'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
   

   }
   

   public function terms_of_use(){
   $data =  DB::table('pages')->first();
    return response()->json(
                [
                    'code' => '200',
                    'message' => 'success',
                    'data' => $data->terms_of_user
                    // 'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
    
   }

   public function getdata(Request $request)
   {
      $user=Auth::user();
       $data=User::where('id',$user->id)->first();

             return response()->json(
                [
                      'data'=>$data,
                ]
                );
   }
 public function updatewithbrowser($rememberme){

     
     $updatedata = array();
$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
{
$rememberme_browser_type = 'mobile';
$rememberme_browser_name = $this->getBrowser();
$rememberme_start_date = date('Y-m-d');


//echo "Mobile browser: " . $this->getBrowser();

//echo '<pre>';print_r($_SERVER);


}else{
$rememberme_browser_type = 'desktop';
$rememberme_browser_name = $this->getBrowser();
$rememberme_start_date = date('Y-m-d');
//echo "Desktop browser: " . $this->getBrowser();
}
$updatedata['rememberme_browser_type'] = $rememberme_browser_type;
$updatedata['rememberme_browser_name'] = $rememberme_browser_name;
$updatedata['rememberme_start_date'] = $rememberme_start_date;
$updatedata['rememberme'] = $rememberme;
//echo '<pre>';print_r($updatedata);exit;
DB::table('users')->where('id', auth()->user()->id)->update($updatedata);


   
}
public function verify_code(Request $request){
       
                $code = $request->code;










$rememberme = $request->rememberme;

$user_id = auth()->user()->id;


                if(auth()->user()->email_varification_code == $code){
                  DB::table('users')->where('id' , auth()->user()->id)->update([
                      'is_email_varified' => 1,
                  ]);
                  if($rememberme=='Yes'){
                        $this->updatewithbrowser($rememberme);
                  }
                  return ["status" => "success" , "message" =>  __('Your Email is Verified Successfully, You Will Be Redirected To Dashboard In A Moment') ];
                }else{
                    return ["status" => "Error" , "message" =>  __('Verification Code Is Wrong! Please Provide Correct Verification Code To Proceed') ];
                }
    }


}
