<?php

namespace App\Http\Controllers\sucrai\admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;

class tribeController extends Controller
{

    public function get_tribe_article(Request $request){
         // $leader = 'This tribe has no leader';
         $tribe = DB::table('tribes')->where('id' , $request->tribe_id)->first();
         // if($tribe->leader != '0'){
         //     $leader = DB::table('users')->where('id' , $tribe->leader)->pluck('name')->first();
         // }               
         $data = DB::table('articles')->where('tribe_id' , $request->tribe_id)->get();
               // dd($data);
               $html = '';
            if(count($data) > 0){    
                       foreach($data as $row){

                        $row->image  = getenv('APP_URL').'/public/images/sucrai/'.$row->image;
                        $row->tribe_name = DB::table('tribes')->where('id' , $row->tribe_id)->pluck('title')->first();
                        $joines = DB::table('user_tribes')->where('tribe_id' , $row->tribe_id);
                        $number_of_users = $joines->count();
                        
                        $html.= '<tr>';
                        $html .='<td>'.$row->article_title.'</td>';
                        $html .='<td>'.DB::table('discussions')->where('discussions.article_id' , $row->id)->join('users' , 'users.id' , '=' , 'discussions.user_id')->count().'</td>';
                        // $html .='<td>'.$leader.'</td>';
                        $html .='<td> <a class=" btn btn-sm btn-dark" href="/tribe/article/details/'.$row->id.'" style="color:white;"><i class="fa fa-eye mr-1"  aria-hidden="true"></i> See Details </a> </td>';
                        $html .= '</tr>';  


                        }
                       }else {
                           $html .= 'No articles found in tribe: '.$tribe->title;
                       } 
return $html;
// <a class="btn btn-sm btn-default" href="url(/course/show_week_details/'.auth()->user()->id.'/'.$value->course_id.'/'.$value->week.'/'.DB::table('courses')->where('id' , $value->course_id)->pluck('clas_id')->first(). ')"> See Details </a></td>';
             

    }
    public function delete_comment(Request $request){

             $comment_id = $request->id;
  //           $article_id = DB::table('discussions')->where('id', $request->id)->pluck('article_id')->first();

   
             $comment_del = DB::table('discussions')->where('id' , $comment_id)->delete();
             if($comment_del){
                       DB::table('discussions')->where('parent_comment_id' , $comment_id)->delete();
                       DB::table('comment_likes')->where('comment_id' , $comment_id)->delete();   
                        }
                    
//             return redirect('article_comments'.$article_id)->with('success','Comment  ');               

}

public function delete_comment_post(Request $request){

             $comment_id = $request->id;
  //           $article_id = DB::table('discussions')->where('id', $request->id)->pluck('article_id')->first();

   
             $comment_del = DB::table('discussions')->where('id' , $comment_id)->delete();
             if($comment_del){
                       DB::table('discussions')->where('parent_comment_id' , $comment_id)->delete();
                       DB::table('comment_likes')->where('comment_id' , $comment_id)->delete();   
                        }
                    
//             return redirect('article_comments'.$article_id)->with('success','Comment  ');               

}



    public function article_comments(Request $request){

                //$data = DB::table('discussions')->where('article_id'=>$request->id)->get();
                
                $data = DB::table('discussions')->where('discussions.article_id' , $request->id)->get();
$article_title = DB::table('articles')->where('id', $request->id)->pluck('article_title')->first();
                //dd($data);
   //echo $article_title;exit;       

return view('admin.articles.article_comments' , compact('data','article_title'));
    




// <a class="btn btn-sm btn-default" href="url(/course/show_week_details/'.auth()->user()->id.'/'.$value->course_id.'/'.$value->week.'/'.DB::table('courses')->where('id' , $value->course_id)->pluck('clas_id')->first(). ')"> See Details </a></td>';
             
    }
    public function article_comments_update(Request $request){

                //$data = DB::table('discussions')->where('article_id'=>$request->id)->get();
             //   echo '<pre>';print_r($_POST);exit;
                DB::table('discussions')->where('id' , $request->discussions_id)->update([
                'comment' => $request->title
        ]);
                return redirect('article_comments/'.$request->article_id)->with('success','Successfully Updated Comment. ');



  }

    public function destroy2(Request $request)
    {
//        dd($request);
//        $id = $request->input("id");
//
//        DB::table('freecomps')->where('user_id',$id)->delete();
//
//        DB::table('users')->where('id',$id)->delete();

        //soft delete code
  $tribe_id = $request->input("id");





$articles = DB::table('articles')->where('tribe_id' , $tribe_id)->get();

$topics = DB::table('topics')->where('tribe_id' , $tribe_id)->get();
//$articles = DB::table('articles')->where('tribe_id' , $request->tribe_id)->get();
               // dd($data);
               $html = '';

if(count($topics) > 0){    
                       foreach($topics as $row){
			$topic_id = $row->id;
DB::table('user_questions')->where('topic_id' , '=' , $topic_id )->delete();

	}
}

//removing discussions
if(count($articles) > 0){    
                       foreach($articles as $row){
			$article_id = $row->id;
DB::table('discussions')->where('article_id' , '=' , $article_id )->delete();

	}
}





DB::table('tribes')->where('id' , '=' , $tribe_id )->delete();
DB::table('articles')->where('tribe_id' , '=' , $tribe_id)->delete();
DB::table('topics')->where('tribe_id' , '=' , $tribe_id)->delete();
DB::table('user_tribes')->where('tribe_id' , '=' , $tribe_id)->delete();

 //DB::table('user_questions')->where('user_id' , $id)->delete();
       

    }






    public function get_tribe_article_view(Request $request){
         // $leader = 'This tribe has no leader';
        
         $data = DB::table('articles')
         ->join('tribes','articles.tribe_id','=','tribes.id')
         ->join('topics','tribes.id','=','topics.tribe_id')
         ->select('articles.id','articles.article_title','articles.image','articles.created_at','tribes.title as tribeTitle','topics.title as topicTitle')
         ->get();
          // echo '<pre>';print_r($data);exit;
          

return view('admin.articles.home' , compact('data'));


// <a class="btn btn-sm btn-default" href="url(/course/show_week_details/'.auth()->user()->id.'/'.$value->course_id.'/'.$value->week.'/'.DB::table('courses')->where('id' , $value->course_id)->pluck('clas_id')->first(). ')"> See Details </a></td>';
             

    }
    public function article_comment_delete(Request $request){
                $comment_id = $request->id;
             $comment_del = DB::table('discussions')->where('id' , $comment_id)->first();

             if($comment_del->parent_comment_id == 0){
                DB::table('discussions')->where('id' , $comment_id)->delete();
                if(DB::table('discussions')->where('parent_comment_id' , $comment_id)->count() > 0){
                    DB::table('discussions')->where('parent_comment_id' , $comment_id)->delete();
                }
                DB::table('comment_likes')->where('comment_id' , $comment_id)->delete();   
             }
             else{
                DB::table('discussions')->where('id' , $comment_id)->delete();
                DB::table('comment_likes')->where('comment_id' , $comment_id)->delete();
             }
    }

    public function tribe_article_details($article_id){
                    // dd($article_id);
                $article_data =  DB::table('articles')->where('id' , $article_id)->first();

                $root_comments = DB::table('discussions')->where('discussions.article_id' , $article_id)->where('discussions.parent_comment_id' , 0)->select('discussions.*' , 'users.name' , 'users.image' )->join('users' , 'users.id' , '=' , 'discussions.user_id')->get();

           
                foreach($root_comments as $root){
                                // $row = DB::table('comment_likes')->where('comment_id'  , $root->id)->get();                             
                                $root->total_likes = DB::table('comment_likes')->where('comment_id'  , $root->id)->where('is_like' , 1)->count();
                        }

                   // dd($root_comments);     

            $root_array = array();
            $child_comments = DB::table('discussions')->where('discussions.article_id' , $article_id)->where('discussions.parent_comment_id' , '!=' , 0)->join('users' , 'users.id' , '=' , 'discussions.user_id')->select('discussions.*' , 'users.name' , 'users.image')->get();
            // dd($child_comments)



          
            if(count($child_comments) > 0){

                  foreach($root_comments as $row){
                    // echo '------------------------------parent root comments----------------------------------';
                    
                    // echo '<pre>';
                    // print_r($row);
                    // echo '----------------------------------------------------------------------------';
                       
                        

                         $all_that_child_comments = DB::table('discussions')->where('discussions.article_id' , $article_id)->where('discussions.parent_comment_id' , $row->id)->select('discussions.*' , 'users.name' , 'users.image')->join('users' , 'users.id' , '=' , 'discussions.user_id')->get();
                  

                    // echo '------------------------------ All Childs----------------------------------';
                    // echo '<pre>';
                    // print_r($all_that_child_comments);
                    // echo '----------------------------------------------------------------------------';

                              foreach($all_that_child_comments as $roo){

                                       // $roww = DB::table('comment_likes')->where('comment_id'  , $roo->id)->get();
                           
                                       $roo->total_likes = DB::table('comment_likes')->where('comment_id'  , $roo->id)->where('is_like' , 1)->count();          

                                   }
                                    $row->child =  $all_that_child_comments;
                          }

                           

                          
                         

                        }

                    else{
                        // dd($root_comments);
                                foreach($root_comments as $row){
                                              $row->child=NULL;
                                }

                    }

            // dd($root_comments);
                    // exit();
                    // dd($article_data);
                    return view('admin.tribe.article_view',compact('root_comments','article_data'));

    }
    public function index(){
                 $data = DB::table('tribes')->get();
                 $user_tribe = DB::table('user_tribes')->get();
//                 dd($usertribe);
                 $users = User::get();
                 
//                 dd($users);
                 foreach ($data as $tribe){
                     $usertribe = DB::table('user_tribes')->where('tribe_id', '=' , $tribe->id)->pluck('user_id');
                     $user = DB::table('users')->whereIn('id' , $usertribe)->get();
                     if(count($user)>0){
                         $tribe->user = $user;
                     }
                     else{
                         $tribe->user = 'false';
                     }
                 }
           // dd($data);
          return view('admin.tribe.home' , compact('data'));
    }



    public function edit_tribe($id){
        $data = DB::table('tribes')->find($id);
        return view('admin.tribe.edit_tribe' , compact('data' , 'id'));
     }


     public function update_tribe_data(Request $request){
        $description = strip_tags(htmlspecialchars_decode($request->description));
        DB::table('tribes')->where('id' , $request->tribe_id)->update([
                'title' => $request->title,
                'description' => $description,
        ]);

         return redirect('tribes')->with('success','Successfully Updated tribe '.DB::table('tribes')->where('id' , $request->tribe_id)->pluck('title')->first());
     }


    public function make_leader($tribe_id , $user_id){
//        dd($tribe_id);
          $tribe = DB::table('tribes')->find($tribe_id);
          $user = DB::table('users')->find($user_id);
//          dd($tribe);
          if($tribe->leader != 0){
              Session::flash('Failed', 'Already an Tribe Leader');
              return redirect()->route('home');
          }
          else{
             $result = DB::table('tribes')->where('id' , '=' , $tribe_id)->update([
                  'leader'=> $user_id,
				 
              ]);
			  
			   
			   // update user role to 3 ( tribe leader )
			   DB::table('users')->where('id' , $user_id)->update([
				   'is_leader' => 1,
			   ]);
              Session::flash('success', 'Successfully Set '. $user->name . ' Tribe Leader of '.$tribe->title);
              return redirect()->route('home');
          }
    }
    public function remove_leader($id){
        $tr = DB::table('tribes')->find($id);
        $user = DB::table('users')->where('id' , '=' , $tr->leader)->first();
        $tribe = DB::table('tribes')->where('id' , '=' , $id)->update([
           'leader'=>0,
        ]);
	   
	  
		if(isset($user->name))	   
        Session::flash('Failed', $user->name . ' is No longer Tribe Leader of '.$tr->title);
		
		DB::enableQueryLog(); // Enable query log

		 // update user role to 0 ( tribe leader )
        $leader_id = $tr->leader;
        $count_of_leader = DB::table('tribes')->where('leader' , $leader_id)->count();
        if($count_of_leader > 0){
            return redirect()->route('tribes.leader');
        }
	   DB::table('users')->where('id' , $tr->leader)->update([
		   'is_leader' => 0,
	   ]);
	   // dd(DB::getQueryLog()); // Show results of log
        return redirect()->route('tribes.leader');
        
    }

    public function remove_from_tribe($tribe_id , $user_id){
        $usertribe = DB::table('user_tribes')->where('user_id' , '=' , $user_id)->where('tribe_id',$tribe_id)->delete();

//        dd($usertribe);
        if($usertribe == 1){
            Session::flash('success', 'Successfully Removed user from Tribe');
            return redirect()->route('home');
        }
        else{
            Session::flash('Failed', 'Some Thing Went Wrong  ');
            return redirect()->route('home');
        }


    }


    public function joinedDetails($id){
         $tribe =DB::table('tribes')->find($id);
         $user_ids = DB::table('user_tribes')->where('tribe_id' , '=' , $id)->pluck('user_id');
         $user = DB::table('users')->whereIn('id' , $user_ids)->get();
//         $user->input = 'asdasdasd';
         return view('admin.tribe.tribe-joined-users', compact('user' , 'tribe'));
    }
    public function remove_user_from_tribe(Request $request){
        // "id" => "230"
        // "tribe_id" => "16"
         $usertribe = DB::table('user_tribes')->where('user_id' , '=' , $request->id)->where('tribe_id',$request->tribe_id)->delete();

    }


    public function adduser($id){
       
        $id =$id;
        $joined_users = DB::table('user_tribes')->where('tribe_id' , '=' , $id)->pluck('user_id');
        $users = DB::table('users')->where('user_role' , 0)->whereNotIn('id' , $joined_users)->get();
        // dd($users);
        return view('admin.tribe.add_user' ,compact('users' , 'id'));
    }


    public function storeuser(Request $request){
        // dd($request->all());
        $tribe_name = DB::table('tribes')->where('id' , $request['id'])->pluck('title')->first();
        $ses_err_message = '';
        foreach ($request->user_id as $user_id) {
            $limit_check = DB::table('user_tribes')->where('tribe_id', $request['id'])->pluck('user_id')->count();
            if($limit_check >= 150){
              $ses_err_message.= 'Maximum 150 users can join a tribe user: '.DB::table('users')->where('id' , $user_id)->pluck('name')->first(). 'not added .,';
                 // Session::flash('success', 'User Already Added.');
                continue;
            }

        $check = DB::table('user_tribes')->where('user_id' , $user_id)->where('tribe_id' , $request['id'])->first();
        // dd($check);
        if($check){
            $ses_err_message.= 'User Already Added.,';
             // Session::flash('success', 'User Already Added.');
             continue;
        }
        $result = DB::table('user_tribes')->insert([
           'user_id'=> $user_id,
            'tribe_id' => $request['id'],
        ]);
        // Session::flash('success', 'Successfully Added User ');
        $ses_err_message.= 'Successfully Added '. DB::table('users')->where('id' , $user_id)->pluck('name')->first().' to tribe '.$tribe_name.',';
         }
   // dd($ses_err_message);
          Session::flash('question_import_error',  $ses_err_message);
          return redirect('tribes');
    }


    public function tribe_leader(){
        $data = DB::table('tribes')->where('leader' , '!=' , 0)->get();
     if(count($data)>0) {
         foreach ($data as $row) {
             $leader = DB::table('users')->where('id', '=', $row->leader)->first();
             $row->leader = $leader;
         }
     }
     else{
         $data = 'false';
     }
	 // dd($data);
            

            return view('admin.tribe-leader.tribe-leaders',compact('data'));
//        dd($leader);
    }
    public function destroy(Request $request){
        $id = $request->input("id");
//        DB::table('question_answers')->where('topic_id' , $id)->delete();
//        DB::table('user_questions')->where('topic_id' , $id)->delete();
        DB::table('topics')->where('tribe_id', $id)->delete();
        DB::table('tribes')->where('id' ,$id )->delete();
    }

    public function add(){
        return view('admin.tribe.add');
    }

    public function stores(Request $request){
        $description = strip_tags(htmlspecialchars_decode($request->description));
        DB::table('tribes')->insert([
            'title' => $request['title'],
            'description' => $description,
            'leader' => '0'

        ]);

        return redirect('tribes')->with('success','Successfully Created');

    }

    public function add_topic($id){
        $topics = DB::table('topics')->whereNull('tribe_id')->get();
         $id = $id;
        if($topics == null ){
            return view('admin.tribe.add_topic',compact('id'));
        }
       
        return view('admin.tribe.add_topic',compact('topics','id'));
    }

    public function store_topic(Request $request){
       
       // dd($request->all());
        foreach($request['topic_id'] as $row){
         DB::table('topics')->where('id',$row)->update([
            'tribe_id' => $request['id']
        ]);
    }


        
            return redirect('tribes')->with('success','Succesfully added');
        
    }

	/* tribe leader in tribes list */
	public function tribesleader()	
	{
		$user_id = Auth::user()->id;
		$leader_in_tribes = DB::table('tribes')->where('leader', $user_id)->get();
		return view('admin.tribe.tribeleader' , compact('leader_in_tribes'));
	}
	public function tribemembers($id)
	{
		$user_id = Auth::user()->id;
		$tribe =DB::table('tribes')->find($id);
		
		$user_ids = DB::table('user_tribes')->where('tribe_id' , '=' , $id)->pluck('user_id');
		// other then admin get tribe users 
		
		// dd($user_ids);
		// skip admin and loggedin tribe leader.
		$user = DB::table('users')->where('user_role' , '!=', '1')->where('id' , '!=', $user_id)->whereIn('id' , $user_ids)->get();
		// dd($user);
        return view('admin.tribe.tribemembers' , compact('user','tribe'));
    }
    public function join_requests(){
         $data = DB::table('join_requests')->join('users' ,'join_requests.user_id' , '=', 'users.id' )
                                                  ->join('tribes','join_requests.tribe_id' ,'=','tribes.id')
                                                  ->select('join_requests.*','users.name as user_name','users.email as user_email','tribes.title as tribe_name')->get();
      
        return view('admin.tribe.join_requests' , compact('data'));                                           
    }
    public function approve_request(Request $request){
              $id = $request->id;
              $join_request = DB::table('join_requests')->where('id',$id)->first();

              $result = DB::table('user_tribes')->insert([
               'user_id'=> $join_request->user_id,
               'tribe_id' => $join_request->tribe_id,
               ]);
            DB::table('join_requests')->where('id' , $id)->delete();
    }

     public function reject_request(Request $request){
        $id = $request->id;
        $join_request = DB::table('join_requests')->where('id',$id)->first();
        $tribe = DB::table('tribes')->where('id' , $join_request->tribe_id)->first();
        $user = DB::table('users')->where('id' , $join_request->user_id)->first();
        $name = $user->name;
        $email = $user->email;
        $message_ = 'Sorry to inform you that your request to join  '. $tribe->title .' is declined by admin';
        $to_name = $name;
        $to_email = $email;
        $data = array(
            "name" => $name,
            "email" => $email,
            "message_" => $message_
        );

        try{
        $message = '<html><body>';
        $message .= '<img style="background:black;" src="https://app.socrai.com/sucrai/assets/images/logo.png" alt="Website Change Request" />';
        $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
        $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($to_name) . "</td></tr>";
        $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($to_email) . "</td></tr>";


        $message .= "<tr><td><strong>Message Content:</strong> </td><td>Sorry to inform you that your request to join" . strip_tags( $tribe->title) . " is declined by admin</td></tr>";
        $message .= "</table>";
        $message .= "</body></html>";


    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $from = 'noreply@socrai.com'; 
    $fromName = 'SOCRAI'; 
    $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n"; 


            mail($to_email, 'Request to join tribe is declined by admin', $message, $headers);
      
    }
    catch(\Exception $e){
            
    }
        
        DB::table('join_requests')->where('id' , $id)->delete();
    }

    // public function reject_request(Request $request){
    //     $id = $request->id;
    //     $join_request = DB::table('join_requests')->where('id',$id)->first();
    //     $tribe = DB::table('tribes')->where('id' , $join_request->tribe_id)->first();
    //     // send email to user:  
    //     // $input = $request->all();
    //     $user = DB::table('users')->where('id' , $join_request->user_id)->first();
    //     $name = $user->name;
    //     $email = $user->email;
    //     $message_ = 'Sorry to inform you that your request to join  '. $tribe->title .' is declined by admin';
    //     $to_name = $name;
    //     $to_email = $email;
    //     $data = array(
    //         "name" => $name,
    //         "email" => $email,
    //         "message_" => $message_
    //     );

    //     try{
    //     $test = Mail::send('emails.request_decline', $data, function ($message) use ($to_name, $to_email) {
    //         $message->to($to_email, $to_name)->subject('Request to join tribe is declined by admin');
    //         $message->from('wonder@socrai.com', 'Socrai');
    //     });
    // }
    // catch(\Exception $e){
        
    // }
        
    //     DB::table('join_requests')->where('id' , $id)->delete();
    // }
	
}
