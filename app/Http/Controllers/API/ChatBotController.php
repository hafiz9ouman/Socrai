<?php

namespace App\Http\Controllers\API;

use Log;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\sucrai\admin\Tribe;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\sucrai\admin\User_tribe;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ChatBotController extends Controller
{
    public $successStatus = 200;
    /**
     * Display list of tribes
     */
    // remove user image b ahmad 15 3 2021
    public function remove_user_image(Request $request)
    {
        $input = $request->all();
        $rules = array(
            // 'tribe_id' => "required|numeric",
            'user_id' => "required|numeric",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user_id = auth('api')->user()->id;
        $user_role = auth('api')->user()->user_role;

        if($user_role!=1){
            if ($user_id != $request->user_id) {
                return response()->json(
                    [
                        'error' => 'User Not Authurized',
                        'message' => 'User Not Authurized',
                        'status' => 'error',
                    ],
                    401
                );
            }
        }
        

        $user = DB::table('users')->where('id', $request->user_id)->first();
        if ($user == null) {
            return response()->json(
                [
                    'error' => 'invalid user id',
                    'message' => 'invalid user id',
                    'status' => 'error',
                ],
                401
            );
        } else {
            $check = DB::table('users')->where('id', $request->user_id)->update([
                'image' => NULL,
            ]);
            $data = DB::table('users')->where('id', $request->user_id)->first();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Image deleted.',
                    'data'   =>  $data->name,
                ],
                200
            );
        }
    }
    public function getTribeMedia(Request $request)
    {
        $tribe_id = $request->tribe_id;
        $user_id = auth('api')->user()->id;
        $checkValidTribe = DB::table('tribes')->where('id', $tribe_id)->first();
        if ($checkValidTribe == null) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Tribe Not found.',
                    // 'data'   =>  $data,
                ],
                200
            );
        }

        if ($checkValidTribe->leader != $user_id) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Only tribe leader can see the media files.',
                    // 'data'   =>  $data,
                ],
                200
            );
        }

        $topics = DB::table('topics')->where('tribe_id', $tribe_id)->pluck('id');
        $media = array();
        foreach ($topics as $topic) {
            $data = array();
            $media_of_tribe = DB::table('media_types')->wherein('topic_id', $topics)->select('mediatype as type', 'file', 'topic_id')->get();
            // dd($media_of_tribe);
            foreach ($media_of_tribe as $key => $value) {
                $value->file = url('public/media/questions_answers/' . $value->file);
            }
            $data = array(
                'topic_name' => DB::table('topics')->where('id', $topic)->pluck('title')->first(),
                'topic_id' => $topic,
                'media' => $media_of_tribe
            );
            // $data->topic_id = $topic;
            // $data->media = $media_of_tribe;
            $media[] = $data;
        }


        return response()->json(
            [
                'status' => 'success',
                'message' => 'success',
                'data'   =>  $media,
            ],
            200
        );
    }
    public function addTribeMEdia(Request $request)
    {



        $input = $request->all();
        $rules = array(
            'topic_id' => "required|numeric",
            'file' => "required",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $empty_array = [];
        $checkValidTopic = DB::table('topics')->where('id', $request->topic_id)->first();
        if ($checkValidTopic == null) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid Topic',
                    'error_messages'   => $empty_array,
                    'total_uploded_files' => '0',
                    // 'data'   =>  $media,
                ],
                200
            );
        }

        $count = 0;
        $ses_err_message = null;
        if ($request->hasFile('file')) {
            $allowedfileExtension = ['mp4', 'jpg', 'JPG', 'png', 'mp3'];
            $files = $request->file('file');
            if (!is_array($files)) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'file must be an array',
                        'error_messages'   => $empty_array,
                        'total_uploded_files' => '0',
                    ],
                    200
                );
            }
            foreach ($files as $file) {
                $filename = date('d_m_y') . '_' . time() . '_' . $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                // dd($extension);
                $check = in_array($extension, $allowedfileExtension);

                if ($check == false) {
                    $ses_err_message .= $extension . ' extension is not supported, Allowed file types are mp4, jpg, JPG, png and mp3' . ';';
                    continue;
                }
                if ($check) {

                    if ($extension != 'mp4') {

                        $file->move(public_path('media/questions_answers'), $filename);
                    } else {
                        $file->move(public_path('media/questions_answers'), $filename);
                    }



                    $cehckIsUploaded =  DB::table('media_types')->insert([
                        "user_id" => auth()->user()->id,
                        "file" => $filename,
                        "mediatype" => $extension,
                        "topic_id" => $request->topic_id,
                    ]);
                    if ($cehckIsUploaded) {
                        $count++;
                    }
                }
            }
            $error_messages  = explode(";", $ses_err_message);
            array_pop($error_messages);
            if ($count  == 0) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'No files uploaded',
                        'error_messages'   => $error_messages,
                        'total_uploded_files' => '0',
                    ],
                    200
                );
            }
            if ($count > 0) {
                return response()->json(
                    [
                        'status' => 'success',
                        'message' => $count . ' ' . (($count > 1) ? 'Files are' : 'File is') . ' uploaded.',
                        'error_messages'   => $error_messages,
                        'total_uploded_files' => $count,
                    ],
                    200
                );
            }
        } else {

            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Please choose files to proceed',
                    // 'data'   =>  $media,
                    'error_messages'   => '',
                    'total_uploded_files' => '0',
                ],
                200
            );
        }
    }
    public function getLeaderTribes(Request $request)
    {
        $leader_id = $request->leader_id;
        $user_id = auth('api')->user()->id;

        $tribes = DB::table('tribes')->where('leader', $leader_id)->select('id as tribe_id', 'title', 'leader as leader_id', 'description')->get();
        if (count($tribes) > 0) {
            foreach ($tribes as $key => $tribe) {
                $tribe->topics = DB::table('topics')->where('tribe_id', $tribe->tribe_id)->select('id as topic_id', 'title as tribe_title', 'tribe_id')->get();
            }
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'success.',
                    'data'   =>  $tribes,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No tribe found.',
                    // 'data'   =>  $tribes,
                ],
                200
            );
        }
    }
    public function tribes()
    {
        if (auth('api')->user()->user_role == '0') {
            // $tribes = Tribe::all();
            $tribes = DB::table('users')
                ->join('user_tribes', 'users.id', '=', 'user_tribes.user_id')
                ->join('tribes', 'tribes.id', '=', 'user_tribes.tribe_id')
                ->select('tribes.*', 'user_tribes.tribe_id')
                ->where('user_tribes.user_id', auth('api')->user()->id)
                ->get();
            return response()->json(['success' => $tribes], $this->successStatus);
        } else {
            // dd(auth('api')->user()->user_role);

            $tribes = DB::table('tribes')->get();
            // dd($tribes)
            return response()->json(['success' => $tribes], $this->successStatus);
        }
    }

    /**
     * un-Joined Tribes ( User Already joined the tribes.)
     *by ahmad saeed 3 2 2021
     */
    public function un_joined_tribes()
    {
        // dd(auth('api')->user()->id);
        $joinedTribes = DB::table('users')
            ->join('user_tribes', 'users.id', '=', 'user_tribes.user_id')
            ->join('tribes', 'tribes.id', '=', 'user_tribes.tribe_id')
            ->select('tribes.*')
            ->where('user_tribes.user_id', auth('api')->user()->id)
            ->pluck('tribes.id');
        $tribes = DB::table('tribes')->whereNotIn('id', $joinedTribes)->get();
        return response()->json(['success' => $tribes], $this->successStatus);
    }
    public function join_requests(Request $request)
    {
        // dd(auth('api')->user()->id);
        // dd($leader_id);
        $leader_id = $request->leader_id;
        $check_is_leader = DB::table('users')->where('id', $leader_id)->pluck('is_leader')->first();
        if ($check_is_leader != 1) {
            return response()->json(
                [
                    'error' => 'invalid leader id',
                    'message' => 'invalid leader id',
                    'status' => 'error',
                ],
                401
            );
        }

        $his_tribe_list = DB::table('tribes')->where('leader', $leader_id)->pluck('id');
        $requests = DB::table('join_requests')->wherein('tribe_id', $his_tribe_list)
            ->join('users', 'join_requests.user_id', '=', 'users.id')
            ->join('tribes', 'join_requests.tribe_id', '=', 'tribes.id')
            ->select('join_requests.*', 'users.name as user_name', 'users.email as user_email', 'tribes.title as tribe_name')->get();
        return response()->json(
            [
                // 'error' => 'invalid leader id',
                'message' => 'success',
                'status' => 'success',
                'data' => $requests,
            ],
            200
        );
    }
    /* Request to join tribe
   * by ahmad saeed 3 2 2021
   */
    public function request_to_join_tribe(Request $request)
    {

        // validation 
        // dd(auth('api')->user()->id);
        $input = $request->all();
        $rules = array(
            'tribe_id' => "required|numeric",
            'user_id' => "required|numeric",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user_id = $request->user_id;
        $tribe_id = $request->tribe_id;

        // cehckif id's exists
        $check = DB::table('users')->where('id', $user_id)->first();
        // dd($check);
        if ($check == null) {
            return response()->json(
                [
                    'error' => 'invalid user id',
                    'message' => 'invalid user id',
                    'status' => 'error',
                ],
                401
            );
        }

        $check = DB::table('tribes')->where('id', $tribe_id)->first();

        if ($check == null) {
            return response()->json(
                [
                    'error' => 'invalid tribe id',
                    'message' => 'invalid tribe id',
                    'status' => 'error',
                ],
                401
            );
        }
        // $check_is_admin = DB::table('users')->where('id' , $user_id)->pluck('user_role')->first();
        // if($check_is_admin != 0){
        //         //check already added:   
        //          $cehck_already_is_added = DB::table('uses_tribes')->where('user_id' , $user_id)->where('tribe_id' , $tribe_id)

        // }

        // cehck number of users
        $limit_check = DB::table('user_tribes')->where('tribe_id', $tribe_id)->pluck('user_id')->count();
        if ($limit_check >= 150) {
            return response()->json(
                [
                    // 'error' => 'invalid user id',
                    'message' => 'Maximum 150 users can join a tribe.',
                    'status' => 'success',
                ],
                200
            );
        }

        $cehck_already_joined = DB::table('user_tribes')->where('user_id', $user_id)->where('tribe_id', $tribe_id)->first();
        if ($cehck_already_joined != null) {
            return response()->json(
                [
                    // 'error' => 'invalid user id',
                    'message' => 'you have already joined this tribe.',
                    'status' => 'success',
                    'data' =>  $cehck_already_joined,
                ],
                200
            );
        }

        $cehck_exists = DB::table('join_requests')->where('user_id', $user_id)->where('tribe_id', $tribe_id)->first();


        if ($cehck_exists != null) {

            return response()->json(
                [
                    // 'error' => 'invalid user id',
                    'message' => 'Request already sent to admin.',
                    'status' => 'success',
                    'data' => $cehck_exists,
                ],
                200
            );
        } else {

            $data = DB::table('join_requests')->insert([
                'user_id' => $user_id,
                'tribe_id' => $tribe_id,
                'created_at' => carbon::now(),
                'updated_at' => carbon::now(),
            ]);
            if ($data) {
                return response()->json(
                    [
                        // 'error' => 'invalid user id',
                        'message' => 'Request has been sent successfully.',
                        'status' => 'success',
                        'data' => DB::table('join_requests')->orderBy('id', 'desc')->first(),
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'error' => 'unable to send join request, please try again later',
                        'message' => 'unable to send join request, please try again later',
                        'status' => 'error',
                    ],
                    401
                );
            }
        }
    }
    /**
     * Joined Tribes ( User Already joined the tribes.)
     */
    public function joinedTribes(Request $request)
    {
        $user_id=Auth::id();
        $data = DB::table('users')
            ->join('user_tribes', 'users.id', '=', 'user_tribes.user_id')
            ->join('tribes', 'tribes.id', '=', 'user_tribes.tribe_id')
            ->select('tribes.title', 'user_tribes.tribe_id')
            // ->select('*')
            ->where('user_tribes.user_id', $user_id)
            ->get();
        return response()->json(
            [
                'code' => '200',
                'message' => "success",
                'data' => $data
            ],
            200
        );
    }
    /**
     * Join Tribe
     */
    public function joinTribe(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'tribe_id' => "required|numeric",
            'user_id' => "required|numeric",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $user_id = $input['user_id'];
            $tribe_id = $input['tribe_id'];
            $check = User_tribe::where('user_id', '=', $user_id)->where('tribe_id', '=', $tribe_id)->first();
            if ($check === null) {  // user not joined.
                // Join user in tribe.
                $user_tribe = new User_tribe();
                $user_tribe->user_id = $user_id;
                $user_tribe->tribe_id = $tribe_id;
                $user_tribe->save();
                DB::table('join_requests')->where('tribe_id', $tribe_id)->where('user_id', $user_id)->delete();
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "User joined tribe  successfully"
                    ],
                    200
                );
            } else {
                // user already exists in group.
                return response()->json(
                    [
                        'code' => '400',
                        'error_description' => "User already joined the Tribe.",
                    ],
                    400
                );
            }
        }
    }
    /**
     * Un-Join Tribe
     */
    public function unJoinTribe(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'tribe_id' => "required|numeric",
            'user_id' => "required|numeric",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $user_id = $input['user_id'];
            $tribe_id = $input['tribe_id'];
            $check = User_tribe::where('user_id', '=', $user_id)->where('tribe_id', '=', $tribe_id)->first();
            if ($check === null) {  // user not joined.
                // user already exists in group.
                return response()->json(
                    [
                        'code' => '400',
                        'error_description' => "User never joined this group.",
                    ],
                    400
                );
            } else {
                // user joined the group.
                DB::table('user_tribes')->where('user_id', $user_id)->where('tribe_id', '=', $tribe_id)->delete();
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "Left successfully"
                    ],
                    200
                );
            }
        }
    }
    /**
     * Dashboard Stats
     */
    public function dashboardStats()
    {
        $user=Auth::user();
        $user_id=$user->id;
        // Get Total questions
        $total_questions = DB::table('user_questions')
            ->where("user_id", "=", $user_id)
            ->pluck("question_answer_id");
        // Get Total tribes joined
        $total_tribes_joined = DB::table('user_tribes')
            ->where("user_id", "=", $user_id)
            ->pluck("tribe_id")
            ->toArray();
        // Get Total Tribes
        $total_tribes = DB::table('tribes')->count();
        $total_tribes_excluding_joined = $total_tribes - count($total_tribes_joined);


        $user_answered_questions = DB::table('user_questions')->where('user_id', $user_id)->pluck('question_answer_id');
        $data = DB::table('question_answers')->wherein('question_answers.id', $user_answered_questions)->where('user_id', $user_id)
            ->join('user_questions', 'user_questions.question_answer_id', '=', 'question_answers.id')->get();


        $total_asked_questions_by_user = count($data);
        $toal_points_earned_by_user = 0;
        foreach ($data as $datum) {
            $toal_points_earned_by_user = (int)$toal_points_earned_by_user + (int)$datum->earned_points + (int)$datum->exercise_unlocked + (int)$datum->exercise_question_true;
        }


        $data = array(
            "total_questions"     => count($total_questions),
            "total_tribes_joined" => count($total_tribes_joined),
            "total_tribes"        => $total_tribes_excluding_joined,
            'total_asked_questions_by_user' => $total_asked_questions_by_user,
            'toal_points_earned_by_user' => $toal_points_earned_by_user,

        );
        return response()->json(
            [
                'code' => '200',
                'message' => 'success',
                'data' => $data
            ],
            200
        );
    }
    /**
     *  * Get List of tribe topics based on tribe_id
     */
    public function getTribesTopics(Request $request)
    {
        $tribe_id = $request->tribe_id;
        // dd('wa;;a');
        $user_id = auth('api')->user()->id; // api loggedIn User
        $topics = DB::table('topics')
            ->select('*')
            ->where('topics.tribe_id', $tribe_id)
            ->get();
        $tribe_details = DB::table('tribes')
            ->select('*')
            ->where('id', $tribe_id)
            ->get();
        $check = User_tribe::where('user_id', '=', $user_id)->where('tribe_id', '=', $tribe_id)->first();
        if ($check === null)   // user not joined.
        {
            $is_tribe_joined = false;
        } else {
            $is_tribe_joined = true;
        }

        $is_request_sent = DB::table('join_requests')->where('user_id', $user_id)->where('tribe_id', $tribe_id)->first();

        if ($is_request_sent == null) {
            $is_request_sent = 0;
        } else {
            $is_request_sent = 1;
        }

        // $user_role = auth('api')->user()->user_role;
        // if($user_role != 0){
        //    $is_tribe_joined = true;

        // }
        // add is_joined index in tribe_details object array.
        $tribe_details->put('is_joined', $is_tribe_joined);
        if (count($topics) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    'data' => $topics,
                    'tribe_details' => $tribe_details,
                    'is_join_request_sent' => $is_request_sent,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'message' => "No Record Found",
                    'tribe_details' => $tribe_details,
                    'is_join_request_sent' => $is_request_sent,
                ],
                200
            );
        }
    }
    /**
     *  * CHATBOT WINDOW USER ASK QUESTION
     */
    public function userAskQuestion(Request $request)
    {
       
        // dd($request->all());
        $topic_id = "";
        $questions = array();
        $input = $request->all();
        $art = $input['question'];     //user type


        $is_exercise = $request->is_exercise;
        $exercise_question = $request->exercise_question;    // actual question in DB    // i have to get its answer and compare it with $art



        $rules = array(
            'question' => "required",
            'topic_id' => "required",
            // 'is_exercise  '=>"required",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $user_asked_question = $input['question'];
            $topic_id = $input['topic_id'];
            // dd($topic_id);

            // Check User Level
            $user_id = auth('api')->user()->id; // api loggedIn User
            // dd($user_id);
            $answerPoints = Db::table('user_questions')->where('user_id', $user_id)->where('topic_id', $topic_id)->count();
            // dd($answerPoints);

            $upgrade_level = '';
            $user_level = $this->getUserLevel($user_id, $topic_id);
            // dd($user_level);
            if ($user_level == 0) {
                $user_level = 1;
            }
            // dd($user_level); 
            // dd($user_level);

            // Level upgrade notification message.
            $upgrade_level = '';
            if ($answerPoints == 15 && $user_level == 1) {
                $upgrade_level = "Level 1 is cleared  " . $user_level;
            } elseif ($answerPoints == 44 && $user_level == 2) {
                $upgrade_level = "Level 2 is cleared " . $user_level;
            } elseif ($answerPoints == 130 && $user_level == 3) {
                $upgrade_level = "Level 3 is cleared " . $user_level;
            }

            // Get User Level questions
            $user_level_questions = $this->getUserLevelQuestions($user_level, $topic_id);
            // dd($user_level_questions);
            // foreach ($user_level_questions as $qq) {
            //     $qq->question = str_replace(array("\r\n", "\r", "\n"), " ", $qq->question);
            // }
            // $output = "\"[";
            // foreach ($user_level_questions as $user_level_question) {
            //     $user_level_question->question = str_replace("'", "", $user_level_question->question);
            //     $output .= "'" . $user_level_question->question . "',";
            // }
            // // $output .= "\'".$user_asked_question."\'"; // added last question.
            // $output .= "'" . $user_asked_question . "'"; // added last question.
            // $output .= "]\"";
            // // question index's
            // $output2 = "[";
            // foreach ($user_level_questions as $user_level_question) {
            //     $output2 .= $user_level_question->id . ",";
            // }
            // // $output .= "\'".$user_asked_question."\'"; // added last question.
            // $output2 .= 00; // added last question.
            // $output2 .= "]";

            // $teststring =  $output;
            if ($is_exercise == 'true') {
                // dd('walla');  
                $actual_answer_in_DB = DB::table('question_answers')->where('question', $exercise_question)->where('topic_id', $topic_id)->first();
                $total_char = strlen((string)$actual_answer_in_DB->answer); 	
                $results = (similar_text($request->question , $actual_answer_in_DB->answer)/$total_char)*100;
                // $actual_answer_in_DB = DB::table('question_answers')->where('question', $exercise_question)->where('topic_id', $topic_id)->pluck('answer')->first();
                // $actual_clue_in_DB = DB::table('question_answers')->where('question', $exercise_question)->where('topic_id', $topic_id)->pluck('clue')->first();
                // $actual_answer_in_DB =   str_replace(array("\r\n", "\r", "\n"), " ", $actual_answer_in_DB);
                // $teststring = "\"['" . $actual_answer_in_DB . "','" . $actual_clue_in_DB . "','" . $art . "']\"";
                // // dd($teststring);
                // $E = "\"['E']\"";
                // $results = exec('python3 /var/www/app.socrai.com/public_html/reversechatbot_twolist_new.py ' . $teststring . ' ' . $E);
                // $results = json_decode($results);
            } else {

                // dd($teststring);
                // $results = exec('python3 /var/www/app.socrai.com/public_html/reversechatbot_twolist.py ' . $teststring . ' ' . $output2); // functional code  new call
                // $results = json_decode($results);
                
            		$confidence_value = ["q_id"=>null , "value"=>0];
            		$searchByQuey = DB::table('question_answers')->where('topic_id', $topic_id)->where(function($q) use($request) {
            										$q->where('question',"like" ,  "%{$request->question}%")->orWhere("clue" ,"like" , "%{$request->question}%" );
            										})->first();

            		// dd($searchByQuey);
                foreach ($user_level_questions as $key => $result_questions) {
                				if($searchByQuey != null){
                					break;
                				}
                				// $confidence_percent = similar_text($request->question , $result_questions->question);
                				$confidence_percent =  (similar_text($request->question , $result_questions->question)/(strlen((string)$result_questions->question)))*100;		
                				if($confidence_value['value'] < $confidence_percent){
                					$confidence_value['value'] = $confidence_percent;
                					$confidence_value['q_id'] = $result_questions->id;
                				}

                				$confidence_percent =  (similar_text($request->question , $result_questions->clue)/(strlen((string)$result_questions->clue)))*100;
                				if($confidence_value['value'] < $confidence_percent){
                					$confidence_value['value'] = $confidence_percent;
                					$confidence_value['q_id'] = $result_questions->id;
                				}
                							
                			}
                			if($searchByQuey == null){
                				if($confidence_value["value"] < 75){
                					$results = null;
                				}else{
                					$results = $confidence_value["q_id"];
                				}
                			}else{

                				$results = isset($searchByQuey->id)?$searchByQuey->id:null;
                			}

                				
                			// return [$confidence_value , $results];

                					
            }

            



            if ($results ==  null) {
                $_themess = "Unable to get your question, please try again with different way";
                // dd($topic_id);
                // dd('yes');
                $check_attempts = Db::table("attempts")->where('user_id', $user_id)->where('topic_id', $topic_id)->first();
                $arr = [];
                $arr[0] = "Sorry, I still don't understand. I'm afraid I'm not a very smart chatbot yet.";
                $arr[1] = "I really like what, why and  how type of questions";
                $arr[2] = "Unable to understand your question, please try again in a different way";
                if ($check_attempts == null) {
                    $_themess = "Sorry, I don't understand your question. Could you try asking it in a different way, Please?";
                    Db::table("attempts")->insert([
                        'user_id' => $user_id,
                        'topic_id' => (int)$topic_id,
                        'attempts' => 1,
                    ]);
                    $total_attempts = 1;
                } else { // not null
                    $total_attempts = $check_attempts->attempts;

                    $selected = rand(0, count($arr) - 1);

                    if ($total_attempts == 1) {
                        $_themess = $arr[$selected];
                    }
                    // if($total_attempts == 1){
                    // $_themess = "Sorry, I still don't understand. I'm afraid I'm not a very smart chatbot yet.";
                    // }
                    if ($total_attempts == 2) {
                        $_themess = "";
                        $_themess_question = DB::table('question_answers')->where('type', 0)->where('topic_id', $topic_id)->inRandomOrder()->first();
                        if (DB::table('question_answers')->where('type', 0)->where('topic_id', $topic_id)->inRandomOrder()->pluck('question')->first() != null) {
                            $_themess = "In this module, we can talk about things like \n \" " .$_themess_question->question  . "\" ";
                        }
                    }
                    if ($total_attempts < 2) {
                        $total_attempts++;
                        Db::table("attempts")->where('user_id', $user_id)->where('topic_id', $topic_id)->update([
                            'user_id' => $user_id,
                            'topic_id' => (int)$topic_id,
                            'attempts' => $total_attempts,
                        ]);
                    } else {
                        $this->resetAttempts($user_id, $topic_id);
                        $clue = $this->getRandomClue($user_level_questions, $topic_id);
                        return response()->json(
                            [
                                'code' => '200',
                                // 'data' => $_themess.' ',
                                // 'clue' => $clue,
                                'data' => (isset($_themess_question) && isset($_themess_question->clue))?'Clue: '.$_themess_question->clue:' ' . ' ',
                                'clue' => $_themess.' '
                            ],
                            200
                        );
                    }
                }
                return response()->json(
                    [
                        'code' => '404',
                        'data' => $_themess,
                    ],
                    200
                );
            } else {

                // dd($request->all());
                // \Artisan::call('cache:clear');
                // \Artisan::call('route:clear');
                // \Artisan::call('config:clear');
                // \Artisan::call('config:cache');
                $question_id = (int)$results;
                $data = null;
                $actual_answer = 'false';
                $cnofidence_level = 'false';
                // dd($request->all());
                if ($is_exercise == true) {

                    // dd('is true');
                    // dd('wallasdasdasa');
                    $data = DB::table('question_answers')
                        ->where('question', $exercise_question)->where('topic_id', $topic_id)
                        ->first();
                    // dd($data);

                    $question_id = $data->id;
                    $cnofidence_level = (int)$results;
                    // dd($cnofidence_level. "asdasd");
                    $actual_answer =  $data->answer;
                    // dd($actual_answer);


                } else {
                    $data = DB::table('question_answers')
                        // ->select('answer','media','media_type','id' , '')
                        ->where('id', $question_id)
                        ->first();
                }

                // dd($question_id);

                if (isset($data)) {
                    // dd('what');
                    // save user asked questions in user_questions
                    $has_record =  DB::table('user_questions')->where('question_answer_id', $question_id)->where('user_id', $user_id)->where('topic_id', $topic_id)->first();

                    // check if asked question is in un-cleared level so we dont have to store its points
                    $check_question_level_uncleared = DB::table('question_answers')->where('id', $question_id)->pluck('level')->first();
                    $topic_point  = DB::table('topics')->where('id', $topic_id)->first();
                    // dd($topic_point);
                    $exercise_unlock_check  = DB::table('question_answers')->where('id', $question_id)->first();
                    $exercise_unlocked_points = 'no';
                    $asking_exercise_points = 'no';

                    if ($exercise_unlock_check->type == 1) {
                        // $check_id_exercise_already_unlocked = DB::table('unlocked_exercises')->where('exercise_id' , $exercise_unlock_check->id)->first();
                        // if(!isset($check_id_exercise_already_unlocked) || $check_id_exercise_already_unlocked == null){  

                        $asking_exercise_points = $topic_point->exercise_points_correct;
                        // }
                        // else{
                        //    $asking_exercise_points = 'no';
                        // }
                    }

                    // check is this asked question is linked to an exercise  (for exercise unlock points)
                    $check_is_linked_to_exercise = DB::table('question_exercise')->where('question_answer_id', $exercise_unlock_check->id)->first();
                    $linked_exercise_to_question;


                    $exercise = false;
                    $exercise_notification = "";
                    $exercise_question = "";
                    $isExercise = $this->checkQuestionExercise($question_id);




                    if (isset($check_is_linked_to_exercise) || $check_is_linked_to_exercise != null) {

                        $ff = DB::table('unlocked_exercises')->where('user_id', $user_id)->where('exercise_id', $check_is_linked_to_exercise->exercise_question_id)->first();
                        if (!isset($ff) || $ff == null) {
                            $linked_exercise_to_question = DB::table('unlocked_exercises')->insert([
                                'user_id' => $user_id,
                                'exercise_id' => $check_is_linked_to_exercise->exercise_question_id,

                            ]);
                        }

                        $exercise_unlocked_points = $topic_point->exercise_points;
                    }


                    $level_crossed = null;
                    $level = 0;
                    $lvl = 1;

                    $level =  $this->getUserLevel($user_id, $topic_id);
                    // dd($level);
                    if ($level == 0) {
                        $lvl = 1;
                    } elseif ($level == 1) {
                        $lvl = 2;
                    } elseif ($level == 2) {
                        $lvl = 3;
                    } else {
                        $lvl = 3;
                    }

                    $questions_ids = DB::table('question_answers')->where('type', 0)->where('topic_id', $topic_id)->where('level', $lvl)->pluck('id');

                    $answerPoints = Db::table('user_questions')->where('user_id', $user_id)->where('topic_id', $topic_id)->wherein('question_answer_id', $questions_ids)->count();
                    // dd($answerPoints);
                    $user_current_level = $lvl;

                    // dd($answerPoints ."    ". $level ); 

                    $upgrade_level = '';
                    if ($answerPoints == 14 && $level == 0) {
                        // dd('walla...');
                        $upgrade_level = " level 1 is cleared  ";

                        $level = 1;
                    } elseif ($answerPoints == 44 && $level == 1) {
                        $upgrade_level = "level 2 is cleared ";
                        $level = 2;
                    } elseif ($answerPoints == 70  && $level == 2) {
                        // dd('wallllla');
                        $upgrade_level = "level 3 is cleared ";
                        $level = 3;
                    } else {
                        $upgrade_level = '';
                    }



                    if ($upgrade_level == '') {
                        $level = 'no';
                    }


                    if ($is_exercise == true) {


                        if ($cnofidence_level < 20) {
                            $asking_exercise_points = 0;
                        }
                    }

                    if ($has_record == null || !isset($has_record)) {
                        DB::table('user_questions')->insert(
                            [
                                'question_answer_id' => $question_id,
                                'user_id' => $user_id,
                                'topic_id' =>  $topic_id,
                                'earned_points' => $topic_point->question_points,
                                'exercise_unlocked' => $exercise_unlocked_points,
                                'exercise_question_true' => $asking_exercise_points,
                                'level_crossed' =>  $level,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),


                            ]
                        );
                    } else {
                        // $check_is_level_crossed =  DB::table('user_questions')->where('question_answer_id' ,$question_id )->where('user_id' , $user_id )->where('topic_id' , $topic_id)->get();
                        //    if($check_is_level_crossed->level_crossed != 'no'){}        
                        DB::table('user_questions')->where('question_answer_id', $question_id)->where('user_id', $user_id)->where('topic_id', $topic_id)->update(
                            [
                                'question_answer_id' => $question_id,
                                'user_id' => $user_id,
                                'topic_id' => $topic_id,
                                'earned_points' => $topic_point->question_points,
                                'exercise_unlocked' => $exercise_unlocked_points,
                                'exercise_question_true' => $asking_exercise_points,
                                // 'level_crossed' =>  $level,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]
                        );
                    }



                    // One correct answer reset attempts
                    $this->resetAttempts($user_id, $topic_id);

                    $type = $this->getMediatype($data);


                    // check if exercise attached with this questions.



                    // dd($isExercise);

                    if (gettype($isExercise) != 'boolean') {
                        // question is attached.
                        $exercise = true;
                        $exercise_notification = "Exercise Unlocked.";

                        $exercise_question =  $this->getExerciseQuestion($isExercise);
                    }

                    if ($exercise_notification != "") {
                        $exercise = 'true';
                    } else {
                        $exercise = 'false';
                    }
                    // if($data[])
                    // asked question user response
                    if ($data->media_type != 'external') {

                        $data->media = env('APP_URL').'/public' . $data->media;
                    }
                    $__the_data = (isset($data->answer) ? str_replace('\"', '"', $data->answer) : '');
                    if($request->is_exercise == true){
                    		$__the_data = ' ';		
                    }
                    return response()->json(
                        [
                            'code' => '200',
                            'message' => "success",
                            'data' => $__the_data,

                            "media_path" => (isset($data->media)) ? $data->media : '',
                            "type" => (isset($type)) ? $type : '',
                            "external" => isset($data->media_type) == "external" ? "true" : "false",

                            // 'level' => (isset($user_level)) ? $user_level : '1',
                            'level' => $user_current_level,
                            'upgrade_level' => $upgrade_level,

                            // exercise                            
                            "exercise" => $exercise,
                            "exercise_notification" => $exercise_notification,
                            // "exercise_question_id"=> $isExercise,
                            "exercise_question" => $exercise_question,
                            "confidence_level" => (string)$cnofidence_level,
                            "actual_answer" => $actual_answer,

                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'code' => '404',
                            'data' => "Sorry, I don't understand your question. Could you try asking it in a different way, Please?",
                            'upgrade_level' => "",
                        ],
                        200
                    );
                }
            }
        }
    }


    // get exercise question.
    private function getExerciseQuestion($question_id = 0)
    {
        $result = Db::table('question_answers')->where('id', '=', $question_id)->first();

        if ($result) {
            return $result->question;
        }

        return "";
    }

    // check question is having any exercise attached. 
    private function checkQuestionExercise($question_id)
    {
        // dd('ealla');
        $check = Db::table('question_exercise')->where('question_answer_id', '=', $question_id)->first();
        // dd($check);
        $user_id = auth('api')->user()->id;
        // dd($user_id);

        if ($check === null) {
            return false;
        }

        $cehck_already_unlocked = DB::table('unlocked_exercises')->where('user_id', '=', $user_id)->where('exercise_id', $check->exercise_question_id)->first();
        if ($cehck_already_unlocked == null) {
            return isset($check->exercise_question_id) ? $check->exercise_question_id : 0;
        }
        return false;
    }

    public function getuserQuestions()
    {
        $user_id = auth('api')->user()->id; // api loggedIn User
        $data = DB::table('user_questions')
            ->join('question_answers', 'question_answers.id', '=', 'user_questions.question_answer_id')
            ->where('user_questions.user_id', $user_id)
            ->get();
        // dd($data);

        if (count($data) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    'data' => $data
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'message' => "No Record Found",
                ],
                200
            );
        }
    }
    //////////////////////////////////////////////
    /**
     * Get User level.
     */
    private function getUserLevel($user_id = 0, $topic_id = 0)
    {

        $level = DB::table('user_questions')->where('user_id', $user_id)->where('topic_id', $topic_id)->where('level_crossed', '!=', 'no')->max('level_crossed');
        // dd($level);
        if ($level == null || !isset($level)) {
            $level = 0;
        }
        // if ($topic_id != 0 )
        // {

        //        $questions_ids = DB::table('question_answers')->where('type' , 0)->where()->pluck('id');
        //        $level = DB::table('user_questions')->wherein('question_answer_id' , $questions_ids)
        //                 ->where("user_id", $user_id)
        //                 ->where("topic_id", $topic_id)      
        //                 ->count();
        //                 // dd($level);
        //     // dd(DB::getQueryLog()); // Show results of log


        // } else {
        //     // $question = DB::table('')

        //     $level = DB::table('user_questions')
        //                 ->where("user_id", $user_id)
        //                 // ->where("topic_id", $topic_id)      
        //                 ->count();
        // }



        // $userlevel = "";
        // $level = $level;
        // // if( $level <= 18) {
        // //     $userlevel = 1;            
        // // } elseif( $level > 18 && $level <= 54 ) {
        // //     $userlevel = 2;
        // // } elseif( $level > 54 ) {
        // //     $userlevel = 3;
        // // }
        // if ($level <= 15) {
        //     $userlevel = 1;
        // } elseif ($level > 15 && $level <= 45) {
        //     $userlevel = 2;
        // } elseif ($level > 130) {
        //     $userlevel = 3;
        // }
        return $level;
    }

    /**
     * Get User Level Questions.
     */
    private function getUserLevelQuestions($level_id = 1, $topic_id)
    {
        // dd($topic_id);
        $user_id = auth('api')->user()->id;
        // dd($user_id);       
        // if ($level_id == 1) {
        $questions = DB::table('question_answers')->where('type', 0)
            // ->where("level", '<=' ,  $level_id)
            ->where('topic_id', $topic_id)
            ->select("question", "id", "clue")

            ->get();

        $unlocked_exercises_ids = DB::table('unlocked_exercises')->where('user_id', $user_id)->pluck('exercise_id');
        $unLocked_exercises = DB::table('question_answers')->where('type', 1)->wherein('id', $unlocked_exercises_ids)
            // ->where("level" , '<=' , $level_id)
            ->where('topic_id', $topic_id)
            ->select("question", "id", "clue")->get();


        $questions = $questions->merge($unLocked_exercises);
        // } elseif ($level_id == 2) {
        //     $questions = DB::table('question_answers')->where('type' , 0)
        //         // ->where("level", '<=' , $level_id)
        //         ->where('topic_id' , $topic_id)
        //         ->select("question", "id", "clue")
        //         ->take(54)
        //         ->get();
        //          $unlocked_exercises_ids = DB::table('unlocked_exercises')->where('user_id' , $user_id )->pluck('exercise_id'); 
        //      $unLocked_exercises = DB::table('question_answers')->where('type' , 1)->wherein('id' , $unlocked_exercises_ids)
        //            // ->where("level",  '<=' ,$level_id)
        //                              ->where('topic_id' , $topic_id)
        //               ->select("question", "id", "clue")->get(); 
        //      $questions = $questions->merge($unLocked_exercises);
        // } elseif ($level_id == 3) {
        //     $questions = DB::table('question_answers')->where('type' , 0)
        //         // ->where("level",  '<=' ,$level_id)
        //         ->where('topic_id' , $topic_id)
        //         ->select("question", "id", "clue")
        //         ->take(162)
        //         ->get();
        //          $unlocked_exercises_ids = DB::table('unlocked_exercises')->where('user_id' , $user_id )->pluck('exercise_id'); 
        //          $unLocked_exercises = DB::table('question_answers')->where('type' , 1)->wherein('id' , $unlocked_exercises_ids)
        //                               // ->where("level", '<=' , $level_id)
        //                               ->where('topic_id' , $topic_id)
        //                              ->select("question", "id", "clue")->get(); 
        //      $questions = $questions->merge($unLocked_exercises);
        // }
        // dd($questions);
        return  $questions;
    }
    // show clue
    public function getClue(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'topic_id' => "required|numeric",
        );
        // dd($input);

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $topic_id = $input['topic_id'];
            $user_id = auth('api')->user()->id; // api loggedIn User
            // dd($user_id . " -- " . $topic_id);

            // get clues
            $user_level = $this->getUserLevel($user_id, $topic_id);
            $user_level_clues = $this->getUserLevelQuestions_($user_level, $topic_id);


            if (count($user_level_clues) > 0) {

                $clue_collection = array();
                foreach ($user_level_clues as $row) {
                    $clue_collection[] = $row->clue;
                }

                return response()->json(
                    [
                        'code' => '200',
                        'message' => "success",
                        'data' => $clue_collection
                    ],
                    200
                );
            } else {

                return response()->json(
                    [
                        'code' => '403',
                        'message' => "No Record Found",
                    ],
                    200
                );
            }
        }
    }


    // answered questions to check the level.
    // $data = DB::table('user_questions')
    //     ->where("user_id",  "=", $user_id)
    //     ->where("topic_id", "=", $topic_id)
    //     ->pluck("question_answer_id");

    // $q = DB::table('question_answers')
    // ->where("topic_id", "=", $topic_id)
    // ->whereNotIn("id", $data);


    /**
     *  Reset attempts
     */
    private function resetAttempts($user_id = 0, $topic_id = 0)
    {
        if ($user_id != 0) {
            Db::table("attempts")->where('user_id', $user_id)->where('topic_id', $topic_id)->delete();
        }
    }
    /** 
     * Get Random Clue
     */
    private function getRandomClue($user_level_questions = null, $topic_id = null)
    {
        // Log::info(print_r($user_level_questions, true));
        // Log::info("---------------------");
        // dd($user_level_questions);
        if ($topic_id != null) {
            $level =  $this->getUserLevel(auth('api')->user()->id, $topic_id);
            // dd($level);
            $lvl;
            if ($level == 0) {
                $lvl = 1;
            } elseif ($level == 1) {
                $lvl = 2;
            } elseif ($level == 2) {
                $lvl = 3;
            } else {
                $lvl = 3;
            }
            $user_level_questions = $user_level_questions->pluck('id');
            $user_level_questions = DB::table('question_answers')->wherein('id',  $user_level_questions)->where('level', $lvl)->select('id', 'clue', 'question')->get();
        }
        if (count($user_level_questions) > 0) {

            $clue_collection = array();
            foreach ($user_level_questions as $row) {
                $clue_collection[] = $row->clue;
            }
            // dd($clue_collection);
            // Log::info(print_r($clue_collection, true));
            // Log::info("random clues are above  ");
            $random_clue_id = array_rand($clue_collection);
            // Log::info(print_r($clue_collection, true));
            // $the_clue = 'No Clues availble for level '.$lvl;
            return isset($clue_collection[$random_clue_id]) ? $clue_collection[$random_clue_id] : '';
        } else {
            return 'There are no clues available at level: ' . $lvl;
        }
    }
    private function getMediatype($data = null)
    {
        $image_type  = array(
            'png',
            'PNG',
            'jpeg',
            'JPEG',
            'jpg',
            'JPG',
            'pjpeg',
            'PJPEG',
            'gif',
            'GIF'
        );

        $video_type  = array('mp4');
        $audio_type  = array('mp3');

        $type = "";
        if (isset($data->media_type)) {

            if ($data->media_type == "external") {
                //get media type
                $filetype = pathinfo($data->media, PATHINFO_EXTENSION);
                if ($filetype == "mp3") {
                    $type = "audio";
                } else {
                    $type = "video";
                }
            } else { // internal media
                if (in_array($data->media_type, $image_type)) {
                    $type = "image";
                } elseif (in_array($data->media_type, $video_type)) {

                    $type = "video";
                } elseif (in_array($data->media_type, $audio_type)) {
                    $type = "audio";
                }
            }
        }

        return $type;
    }

    /**
     * Get User Level Questions by topic.
     */
    private function getUserLevelQuestions_($level_id = 1, $topic_id = 0)
    {

        if ($level_id == 1) {
            $questions = DB::table('question_answers')
                ->where("level", $level_id)
                ->where("topic_id", $topic_id)
                ->select("question", "id", "clue")
                ->take(18)
                ->get();
        } elseif ($level_id == 2) {
            $questions = DB::table('question_answers')
                ->where("level", $level_id)
                ->where("topic_id", $topic_id)
                ->select("question", "id", "clue")
                ->take(54)
                ->get();
        } elseif ($level_id == 3) {
            $questions = DB::table('question_answers')
                ->where("level", $level_id)
                ->where("topic_id", $topic_id)
                ->select("question", "id", "clue")
                ->take(162)
                ->get();
        }
        return  $questions;
    }



    public function getAllClues(Request $request)
    {
        $topic_id = $request->topic_id;
        // dd('walla');
        $data = DB::table('question_answers')->where('topic_id', $topic_id)->select('clue')->get();
        $cnt = count($data);
        $test_question = DB::table('question_answers')->where('topic_id', $topic_id)->select('question', 'clue')->get();
        if (count($test_question) > 0) {
            $test_question = $test_question[rand(0, $cnt - 1)];
        } else {
            $test_question = false;
        }



        // $message = 'Hellow '.DB::table('users')->where('id' , auth('api')->user()->id)->pluck('name')->first().', Welcome back ';
        // changed this on 4 30 2021
        // $message = '<h5> Welcome back '.DB::table('users')->where('id' , auth('api')->user()->id)->pluck('name')->first().', </h5><br> <p> In this section we can talk about like <strong> '.$test_question->question.'</strong> </p>';
        // added this on 4 30 2021 bt ahmad because of feedback
        if ($test_question) {
            $message = '<h5> Welcome back ' . DB::table('users')->where('id', auth('api')->user()->id)->pluck('name')->first() . ', </h5><br> <p> In this section we can talk about <strong> ' . $test_question->clue . '</strong> </p>';
        } else {
            $message = '<h5> Welcome back ' . DB::table('users')->where('id', auth('api')->user()->id)->pluck('name')->first() . ', </h5><br> <p>Currently there are no questions available in this section. You can vist again later.</p>';
        }
        // dd($cnt);
        if ($cnt == 0) {
            // $data = DB::table('question_answers')->where('topic_id' , $topic_id)->select('clue')->get();
            $data = DB::table('question_answers')->select('clue')->first();
            // $data = $data[rand(0,$cnt-1)];
            $data->clue = 'Right now there is no question/clue available in this topic.';
        } else {

            $data = $data[rand(0, $cnt - 1)];
            // $topic_name = DB::table('topics')->where('id' , $topic_id)->
        }


        return response()->json(
            [
                'code' => '200',
                'message' => "success",
                'message' => $message,
                // 'clue' => $data
            ],
            200
        );
    }






    // ARTICLE SECTION






    public function make_article(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'tribe_id' => "required|numeric",
            'article_title' => "required",
            'description' => "required",
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            // return response()->json(['error' => $validator->errors()], 401);
            return response()->json(
                [
                    'code' => '403',
                    'message' => "Something is Wrong",
                ],
                403
            );
        } else {


            if ($files = $request->file('image')) {
                $name = $files->getClientOriginalName();
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
                $files->move(public_path('images/sucrai'), $name);
            } else {
                return response()->json(
                    [
                        'code' => '403',
                        'message' => "No image found!",
                    ],
                    403
                );
            }


            // $leader = DB::table('users')->where('id' , $input['leader_id'])->first();
            $tribe =  DB::table('tribes')->where('id', $input['tribe_id'])->first();

            if ($tribe == null || !isset($tribe)) {
                return response()->json(
                    [
                        'code' => '403',
                        'message' => "no tribe found!",
                    ],
                    200
                );
            }

            $user = auth('api')->user();
            // if($user->role != 1){
                // if($tribe->leader != $user->id){
                //     return response()->json(['error' => 'Unauthorized'], 403);
                // }
            // }
            


            $data = DB::table('articles')->insert([

                "tribe_id" => $input['tribe_id'],
                "article_title" => $input['article_title'],
                "description" => $input['description'],
                "image" => $name,
                'leader_id' => auth('api')->user()->id,
            ]);
            // $data = DB::table('users')->where('article_title' , $input['article_title'])->first();


            return response()->json(
                [
                    'code' => '200',
                    'message' => "successfully created article",
                ],
                200
            );
        }
    }

    public function get_articles_by_tribe_id(Request $request)
    {
        $tribe_id = $request->tribe_id;

        $rr = DB::table('tribes')->where('id', $tribe_id)->first();
        if (!isset($rr) || $rr  == null) {

            return response()->json(
                [
                    'code' => '404',
                    'message' => "tribe not found",
                ],
                404
            );
        }
        
        $user = auth('api')->user();
        $user_id = auth('api')->user()->id;
        $user_role = auth('api')->user()->user_role;
        $user_ids = DB::table('user_tribes')->where('tribe_id', $tribe_id)->pluck('user_id');

        if($user_role != 1){ 
            if($user->is_leader!=1){
                $user_id=trim($user_id);
                $exist=0;
                foreach($user_ids as $u_id){
                    if($user_id == trim($u_id)){
                        $exist=1;
                    }
                }
                if ($exist != 1) {  //check the user existance in the tribe
                    return response()->json([
                        'code' => '403',
                        'message' => 'Unauthorized User',
                    ]);
                }
            } /// for site admin
        }
        // if(!$user){
        //     return response()->json([
        //         'code' => '403',
        //         'message' => 'Unauthorized User',
        //     ]);
        // }
        // dd($user_id);
        // $joined_tribe_id = DB::table('user_tribes')->where('user_id' , $user_id)->pluck('tribe_id');

        // $data = DB::table('articles')->wherein('tribe_id' , $joined_tribe_id )->where('leader_id' , $tribe_id)->get();
        // $data = DB::table('articles')->where('tribe_id' , $tribe_id)->get();
        $data = DB::table('articles')->where('tribe_id', $tribe_id)->get();
        if (!(count($data) > 0)) {
            if (!isset($rr) || $rr  == null) {

                return response()->json(
                    [
                        'code' => '404',
                        'message' => "this tribe has no articels",
                    ],
                    404
                );
            }
        }
        foreach ($data as $row) {
            $row->image  = env('APP_URL').'/public/images/sucrai/' . $row->image;
            $row->tribe_name = DB::table('tribes')->where('id', $row->tribe_id)->pluck('title')->first();

            // check if user joined this tribe
            $joined_tribe_id = DB::table('user_tribes')->where('user_id', $user_id)->where('tribe_id', $row->tribe_id)->first();
            if (isset($joined_tribe_id) || $joined_tribe_id != null) {

                $row->is_joined = 'yes';
            } else {
                $row->is_joined = 'no';
            }
        }
        // dd($data);       

        // dd($data);
        if (!isset($data) ||  $data == null) {

            return response()->json(
                [
                    'code' => '404',
                    'message' => "no article found",
                ],
                404
            );
        } else {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    // 'tribe' => $tribe_id,
                    'articles' => $data
                ],
                200
            );
        }
    }
    public function get_articles(Request $request)
    {

        // $rr = DB::table('tribes')->where('id' , $tribe_id) ->first();
        // if(!isset($rr) || $rr  == null){

        //    return response()->json([
        //                                 'code' => '404',
        //                                 'message' => "tribe not found",
        //                             ],
        //                             404
        //                         );
        // }

        $user_id = auth('api')->user()->id;
        // dd($user_id);
        // $joined_tribe_id = DB::table('user_tribes')->where('user_id' , $user_id)->pluck('tribe_id');

        // $data = DB::table('articles')->wherein('tribe_id' , $joined_tribe_id )->where('leader_id' , $tribe_id)->get();
        // $data = DB::table('articles')->where('tribe_id' , $tribe_id)->get();
        $data = DB::table('articles')->get();
        // dd($data);
        foreach ($data as $row) {
            $row->image  = env('APP_URL').'/public/images/sucrai/' . $row->image;
            $row->tribe_name = DB::table('tribes')->where('id', $row->tribe_id)->pluck('title')->first();

            // check if user joined this tribe
            $joined_tribe_id = DB::table('user_tribes')->where('user_id', $user_id)->where('tribe_id', $row->tribe_id)->first();
            if (isset($joined_tribe_id) || $joined_tribe_id != null) {

                $row->is_joined = 'yes';
            } else {
                $row->is_joined = 'no';
            }
        }
        // dd($data);       

        // dd($data);
        if (!isset($data) ||  $data == null) {

            return response()->json(
                [
                    'code' => '404',
                    'message' => "no article found",
                ],
                404
            );
        } else {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    // 'tribe' => $tribe_id,
                    'articles' => $data
                ],
                200
            );
        }
    }
    
    public function get_comment(Request $request)
    {
        try {
            $article_id = $request->article_id;
    
            $root_comments = DB::table('discussions')
                ->where('discussions.article_id', $article_id)
                ->where('discussions.parent_comment_id', 0)
                ->select('discussions.*', 'users.name', 'users.image')
                ->join('users', 'users.id', '=', 'discussions.user_id')
                ->get();
    
            foreach ($root_comments as $root) {
                $row = DB::table('comment_likes')
                    ->where('comment_id', $root->id)
                    ->get();
    
                if ($row) {
                    $table = DB::table('comment_likes')
                        ->where('comment_id', $root->id)
                        ->where('user_id', auth('api')->user()->id)
                        ->first();
    
                    if ($table) {
                        $root->is_current_user_liked = true;
                    } else {
                        $root->is_current_user_liked = false;
                    }
    
                    $root->total_likes = DB::table('comment_likes')
                        ->where('comment_id', $root->id)
                        ->where('is_like', 1)
                        ->count();
                } else {
                    $root->is_current_user_liked = false;
                    $root->total_likes = DB::table('comment_likes')
                        ->where('comment_id', $root->id)
                        ->where('is_like', 1)
                        ->count();
                }
            }
    
            $root_array = array();
            $child_comments = DB::table('discussions')
                ->where('discussions.article_id', $article_id)
                ->where('discussions.parent_comment_id', '!=', 0)
                ->join('users', 'users.id', '=', 'discussions.user_id')
                ->select('discussions.*', 'users.name', 'users.image')
                ->get();
    
            if (count($child_comments) > 0) {
                foreach ($root_comments as $row) {
                    $all_that_child_comments = DB::table('discussions')
                        ->where('discussions.article_id', $article_id)
                        ->where('discussions.parent_comment_id', $row->id)
                        ->select('discussions.*', 'users.name', 'users.image')
                        ->join('users', 'users.id', '=', 'discussions.user_id')
                        ->get();
    
                    foreach ($all_that_child_comments as $roo) {
                        $roww = DB::table('comment_likes')
                            ->where('comment_id', $roo->id)
                            ->get();
    
                        if ($roww) {
                            $table = DB::table('comment_likes')
                                ->where('comment_id', $roo->id)
                                ->where('user_id', auth('api')->user()->id)
                                ->first();
    
                            if ($table) {
                                $roo->is_current_user_liked = true;
                            } else {
                                $roo->is_current_user_liked = false;
                            }
    
                            $roo->total_likes = DB::table('comment_likes')
                                ->where('comment_id', $roo->id)
                                ->where('is_like', 1)
                                ->count();
                        } else {
                            $roo->is_current_user_liked = false;
                            $roo->total_likes = DB::table('comment_likes')
                                ->where('comment_id', $roo->id)
                                ->where('is_like', 1)
                                ->count();
                        }
                    }
    
                    $row->child =  $all_that_child_comments;
    
                    array_push($root_array, array(
                        'parent_comment' => $row,
                    ));
                }
            } else {
                foreach ($root_comments as $row) {
                    $row->child = "";
                    array_push($root_array, array(
                        'parent_comment' => $row,
                    ));
                }
            }
    
            $user_id = Auth::user()->id;
            $user_role = Auth::user()->user_role;
            $is_joined = '';
            $tribe_id_of_article = DB::table('articles')->where('id', $article_id)->value('tribe_id');
            $check_joined = DB::table('user_tribes')
                ->where('user_id', $user_id)
                ->where('tribe_id', $tribe_id_of_article)
                ->first();
    
            if (isset($check_joined) || $check_joined != null) {
                $is_joined = 'yes';
            } else {
                $is_joined = 'no';
                if($user_role != 1){
                    return response()->json([
                        'code' => '403',
                        'message' => "Unauthorized User",
                    ], 403);
                }
                
            }
    
            if (!empty($root_array)) {
                return response()->json([
                    'code' => '200',
                    'message' => "success",
                    'is_joined' => $is_joined,
                    'comments' => $root_array,
                ], 200);
            } else {
                return response()->json([
                    'code' => '200',
                    'message' => "No comments yet",
                ], 200);
            }
        } catch (\Exception $e) {
            // Log the error message
            $errorMessage = $e->getMessage();
            $errorLine = $e->getLine();
            error_log($e->getMessage());
    
            return response()->json([
                'code' => '500',
                'message' => "Server Error",
                'error' => [
                    'message' => $errorMessage,
                    'line' => $errorLine,
                ],
            ], 500);
        }
    }
    

    private function get_level_cross_details($user_id, $topic_id, $level)
    {

        // dd($user_id . "  " .$topic_id . "  " . $level);
        $result = array();
        $current_level_questions = DB::table('question_answers')->where('level', $level)->where('topic_id', $topic_id);
        $count_q =  $current_level_questions->count();
        $ids = $current_level_questions->pluck('id');
        $correct_answer = DB::table('user_questions')->wherein('question_answer_id', $ids)->count();
        $level_passed_date = DB::table('user_questions')->where('level_crossed', $level)->pluck('created_at')->first();
        $all_answered_questions_data =  DB::table('user_questions')->wherein('question_answer_id', $ids)->get();
        $points = 1;
        foreach ($all_answered_questions_data as $row) {
            $points = (int)$points + (int)$row->earned_points + (int)$row->exercise_unlocked + (int)$row->exercise_question_true;
        }
        // dd($count_q);
        array_push($result, array(
            // "topic" => DB::table('topics')->where('id' , $topic_id)->pluck('title')->first(),
            // "topic_id" => $topic_id,
            "total_questions" => $count_q,
            "correct_questions" => $correct_answer,
            "level" => $level,
            "points" => $points,
            "cleared_date" => $level_passed_date,
            "user_id" => $user_id,
            "user_name" => DB::table('users')->where('id', $user_id)->pluck('name')->first(),
        ));
        return $result;
    }




    // get crossed levels 
    public function get_level_crossed()
    {
        $user_id=Auth::id();
        // dd($user_id);
        // $user_answered_questions = DB::table('user_questions')->where('user_id' , $user_id)->where;
        $total_topics = DB::table('user_questions')->where('user_id', $user_id)->pluck('topic_id')->unique();
        // dd($total_topics);

        // check for level 1
        $all_level_crossed = DB::table('user_questions')->where('user_id', $user_id)->where('level_crossed', '!=', 'no')->pluck('level_crossed')->unique();
        $all_data = array();

        foreach ($total_topics as $topic_id) {
            // dd($topic_id);
            $all_data_of_topic = array();
            foreach ($all_level_crossed as $row) {
                // $topic_id = DB::table('user_questions')->where('level_crossed' , $row)->pluck('topic_id')->first();
                $d =  $this->get_level_cross_details($user_id, $topic_id, $row);

                array_push($all_data_of_topic, array(

                    'level' => $row,
                    'level_clear_details' => $d,
                ));
            }

            array_push($all_data, array(
                'topic_name' => DB::table('topics')->where('id', $topic_id)->pluck('title')->first(),
                'topic_id' => $topic_id,
                'level_clear_data_by_level' => $all_data_of_topic,

            ));
        }

        if (count($all_data) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    "data" => $all_data,

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'message' => "user have't cleared any level yet",
                    // "data" => $all_data,

                ],
                200
            );
        }
    }

    public function get_topic_list_for_points()
    {
        $user_id=Auth::id();
        $data = DB::table('user_questions')->where('user_id', $user_id)->pluck('topic_id')->unique();
        if (count($data) > 0) {
            // dd($data);
            $topics = DB::table('topics')->wherein('id', $data)->select('id', 'title')->get();

            return response()->json(
                [
                    'code' => '200',
                    'status' => "success",
                    "data" => $topics,
                ],
                200
            );
        } else {

            return response()->json(
                [
                    'code' => '403',
                    'status' => 'error',
                    'message' => "user have't answwerd any question",
                    // "data" => $topics,
                ],
                200
            );
        }
    }

    public function  get_points_topic_wise(Request $request)
    {
                 $user_id=Auth::id();
                 $topic_id = $request->topic_id;
        $user_answered_questions = DB::table('user_questions')->where('user_id', $user_id)->pluck('question_answer_id');
        // $total_topics = DB::table('user_questions')->where('user_id' , $user_id)->pluck('topic_id')->unique();
        if (isset($user_answered_questions)) {

            $topic_questions_answers = array();
            if (count($user_answered_questions) > 0) {
                $data = DB::table('question_answers')->wherein('question_answers.id', $user_answered_questions)->where('user_id', $user_id)
                    ->join('user_questions', 'user_questions.question_answer_id', '=', 'question_answers.id')->get();

                $topic_wise_points;
                $topic_wise_points_p;

                // foreach($total_topics as $top){
                $topic_wise = $data->where('topic_id', $topic_id);
                if (!(count($topic_wise) > 0)) {

                    return response()->json(
                        [
                            'code' => '200',
                            'message' => "No data found!",

                        ],
                        200
                    );
                }

                foreach ($topic_wise as  $value) {
                    # code...
                    $topic_wise_points_p[] = $value;
                }


                $points = 0;
                $count = 0;
                $exercise_counts = 0;
                foreach ($data as $row) {
                    if ($row->topic_id == $topic_id) {
                        $points = (int)$points + (int)$row->earned_points + (int)$row->exercise_unlocked + (int)$row->exercise_question_true;
                        $count++;
                        if ($row->type == 1) {
                            $exercise_counts++;
                        }
                    }
                }

                $obt = (object) null;
                $obt->topic_name = DB::table('topics')->where('id', $topic_id)->pluck('title')->first();
                $obt->questions_ask_at_this_topic = $count;
                $obt->total_answered_exercises = $exercise_counts;
                $obt->points_at_this_topic = $points;
                $obt->questions_answers_at_this_topic = $topic_wise_points_p;

                $topic_wise_points[] = $obt;

                $topic_wise_points_p = null;



                //                       array_push($topic_wise_points, array(
                // // "topic_name" => DB::table('topics')->where('id' , $top)->pluck('title')->first(),
                // //                              "questions_ask_at_this_topic" => $count,
                // // "total_answered_exercises" => $exercise_counts,
                // //                                "points_at_this_topic" => $points,
                // //                                 "questions_answers_at_this_topic" => $topic_wise,
                //                              "data" => $obt,

                //        ));    


                // }
                // $total_asked_questions_by_user = count($data); 
                // $toal_points_earned_by_user = 0;
                // foreach ($data as $datum) {
                //     $toal_points_earned_by_user = (int)$toal_points_earned_by_user + (int)$datum->earned_points + (int)$datum->exercise_unlocked + (int)$datum->exercise_question_true;
                // }

                return response()->json(
                    [
                        'code' => '200',
                        'message' => "success",
                        // 'data' => $data,
                        'topic_wise_points' => $topic_wise_points,
                        // 'total_asked_questions_by_user' => $total_asked_questions_by_user,
                        // 'toal_points_earned_by_user' => $toal_points_earned_by_user,

                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "No data found!",

                    ],
                    200
                );
            }
        } else {

            return response()->json(
                [
                    'code' => '200',
                    'message' => "No data found!",

                ],
                200
            );
        }
    }

    public function get_points()
    {
             $user=Auth::user();
             $user_id=$user->id;
          $user_answered_questions = DB::table('user_questions')->where('user_id', $user_id)->pluck('question_answer_id');
          $total_topics = DB::table('user_questions')->where('user_id', $user_id)->pluck('topic_id')->unique();
          if (isset($user_answered_questions)) {

            $topic_questions_answers = array();
            if (count($user_answered_questions) > 0) {
                $data = DB::table('question_answers')->wherein('question_answers.id', $user_answered_questions)->where('user_id', $user_id)
                    ->join('user_questions', 'user_questions.question_answer_id', '=', 'question_answers.id')->get();

                $topic_wise_points = [];
                $topic_wise_points_p = [];

                foreach ($total_topics as $top) {
                    $topic_wise = $data->where('topic_id', $top);
                    foreach ($topic_wise as  $value) {
                        # code...
                        $topic_wise_points_p[] = $value;
                    }


                    $points = 0;
                    $count = 0;
                    $exercise_counts = 0;
                    foreach ($data as $row) {
                        if ($row->topic_id == $top) {
                            $points = (int)$points + (int)$row->earned_points + (int)$row->exercise_unlocked + (int)$row->exercise_question_true;
                            $count++;
                            if ($row->type == 1) {
                                $exercise_counts++;
                            }
                        }
                    }

                    $obt = (object) null;
                    $obt->topic_name = DB::table('topics')->where('id', $top)->pluck('title')->first();
                    $obt->questions_ask_at_this_topic = $count;
                    $obt->total_answered_exercises = $exercise_counts;
                    $obt->points_at_this_topic = $points;
                    $obt->questions_answers_at_this_topic = $topic_wise_points_p;

                    $topic_wise_points[] = $obt;

                    $topic_wise_points_p = null;



                    //                       array_push($topic_wise_points, array(
                    // // "topic_name" => DB::table('topics')->where('id' , $top)->pluck('title')->first(),
                    // //                              "questions_ask_at_this_topic" => $count,
                    // // "total_answered_exercises" => $exercise_counts,
                    // //                                "points_at_this_topic" => $points,
                    // //                                 "questions_answers_at_this_topic" => $topic_wise,
                    //                              "data" => $obt,

                    //        ));    


                }
                $total_asked_questions_by_user = count($data);
                $toal_points_earned_by_user = 0;
                foreach ($data as $datum) {
                    $toal_points_earned_by_user = (int)$toal_points_earned_by_user + (int)$datum->earned_points + (int)$datum->exercise_unlocked + (int)$datum->exercise_question_true;
                }

                return response()->json(
                    [
                        'code' => '200',
                        'message' => "success",
                        // 'data' => $data,
                        'topic_wise_points' => $topic_wise_points,
                        'total_asked_questions_by_user' => $total_asked_questions_by_user,
                        'toal_points_earned_by_user' => $toal_points_earned_by_user,

                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "No data found!",

                    ],
                    200
                );
            }
        } else {

            return response()->json(
                [
                    'code' => '200',
                    'message' => "No data found!",

                ],
                200
            );
        }
    }


    public function post_comment(Request $request)
    {
           $user=Auth::user();

        $input = $request->all();
        $user_id=$user->id;
        $rules = array(

            'article_id' => "required|numeric",
            'comment' => "required",
            'parent_comment_id' => "required",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $r =  DB::table('discussions')->insert([
                "user_id" => $user_id,
                "article_id" => $input['article_id'],
                "comment" => $input['comment'],
                "parent_comment_id" => $input['parent_comment_id'],
                "created_at" => Carbon::now(),
            ]);


            $data = DB::table('discussions')->orderBy('id', 'desc')->select('id','parent_comment_id','article_id','comment','created_at','updated_at')->first();
            // dd($r);

            //  if(!isset($r) || $r == 'false'){
            //     return response()->json(
            //     [
            //         'code' => '403',
            //         'message' => "can't add comment, something went wrong.",

            //     ],
            //     403
            // );

            // }
            // else{
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    'data' => $data,

                ],
                200
            );
            // }

        }
    }


    public function get_leader_tribes()
    {

        // dd('walla');
        $leader_id=Auth::id();

        $tribes = DB::table('tribes')->where('leader', $leader_id)->get();
        if (count($tribes) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    'tribes' => $tribes,

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'message' => "This user is not leader of any tribe",
                    // 'data' => $data, 

                ],
                200
            );
        }
    }

    public function get_users_of_tribe(Request $request)
    {
        // dd("tribe id =>" . $tribe_id);
        $tribe_id = $request->tribe_id;
        $check_if_tribe = DB::table('tribes')->where('id', $tribe_id)->first();
        if (!isset($check_if_tribe) || $check_if_tribe == null) {
            return response()->json([
                'code' => '403',
                'message' => 'invalid tribe id'
            ], 200);
        }

        $user_ids = DB::table('user_tribes')->where('tribe_id', $tribe_id)->pluck('user_id');

        $auth_user=auth('api')->user()->id;
        $auth_role=auth('api')->user()->user_role;
        if($auth_role != 1){
            if($auth_user != $check_if_tribe->leader)
            return response()->json([
                'code' => '403',
                'message' => 'Unauthorized User',
            ]);
        }

        $users = DB::table('users')->where('user_role', '!=', '1')->where('user_role', '!=', '2')->where('is_leader', '!=', '1')->wherein('id', $user_ids)->select('id', 'name', 'image', 'email')->get();
        // dd($users);
        if (count($users) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'message' => "success",
                    'data' => $users,

                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'message' => "No user joined this tribe",
                    // 'data' => $data, 
                ],
                200
            );
        }
    }

    public function edit_article(Request $request)
    {

        $input = $request->all();
        $rules = array(
            'tribe_id' => "required|numeric",
            'article_id' => "required|numeric",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {

            $old = DB::table('articles')->find($input['article_id']);
            $name = null;
            $title = null;
            $description = null;
            if ($files = $request->file('image')) {
                $name = $files->getClientOriginalName();
                $files->move(public_path('images/sucrai'), $name);
            } else {
                $name = $old->image;
            }

            if ($request->article_title) {
                $title = $request->article_title;
            } else {
                $title = $old->article_title;
            }

            if ($request->description) {
                $description = $request->description;
            } else {
                $description = $old->description;
            }

            if ($request->tribe_id) {
                $tribe_id = $request->tribe_id;
            } else {
                $tribe_id = $old->tribe_id;
            }

            $up =  DB::table('articles')->where('id', $input['article_id'])->update([
                'article_title' => $title,
                'description' => $description,
                'tribe_id' => $tribe_id,
                'image' => $name,
                'updated_at' => \carbon\carbon::now(),
            ]);

            if ($up) {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "Succcessfully updated",
                        'data' => DB::table('articles')->find($input['article_id']),
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => '200',
                        'error' => "somthing went wrong",
                        'message' => 'something went wrong',
                        // 'data' => DB::table('articles')->find($input['tribe_id']),                              
                    ],
                    200
                );
            }
        }
    }

    public function remove_user_from_tribe(Request $request)
    {

        $input = $request->all();
        $rules = array(

            'user_id' => "required|numeric",
            'tribe_id' => "required|numeric",
            // 'comment' => "required",
            // 'parent_comment_id' =>"required",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $check_if_tribe = DB::table('tribes')->where('id', $request->tribe_id)->first();
            if (!isset($check_if_tribe) || $check_if_tribe == null) {
                return response()->json([
                    'code' => '422',
                    'message' => 'invalid tribe id'
                ], 422);
            }

            $check_if_user = DB::table('users')->where('id', $request->user_id)->first();
            if (!isset($check_if_user) || $check_if_user == null) {
                return response()->json([
                    'code' => '422',
                    'message' => 'invalid user id'
                ], 422);
            }

            // dd('validated');
            $check = DB::table('user_tribes')->where('user_id', '=', $request->user_id)->where('tribe_id', $request->tribe_id)->first();
            // dd($check);
            if ($check == null) {
                return response()->json(
                    [
                        'code' => '422',
                        'message' => "Warning! wrong input",
                        // 'data' => $users,    

                    ],
                    422
                );
            }

            $usertribe = DB::table('user_tribes')->where('user_id', '=', $request->user_id)->where('tribe_id', $request->tribe_id)->delete();
            if ($usertribe == 1) {
                // to delete answerd questions of that user 
                $topic_ids = DB::table('topics')->where('tribe_id', $request->tribe_id)->pluck('id');
                // dd($topic_ids);
                $asked_questions_ids =  DB::table('user_questions')->where('user_id', $request->user_id)->wherein('topic_id', $topic_ids)->pluck('question_answer_id');
                DB::table('user_questions')->where('user_id', $request->user_id)->wherein('topic_id', $topic_ids)->delete();
                // to delete comments of that user
                $articles_ids = DB::table('articles')->where('tribe_id', $request->tribe_id)->pluck('id');
                DB::table('discussions')->wherein('article_id', $articles_ids)->where('user_id', $request->user_id)->delete();
                // to delete unlocked exercise record
                DB::table('unlocked_exercises')->where('user_id', $request->user_id)->wherein('exercise_id', $asked_questions_ids)->delete();


                return response()->json(
                    [
                        'code' => '200',
                        'message' => DB::table('users')->where('id', $request->user_id)->pluck('name')->first() . "  is removed from tribe  " . DB::table('tribes')->where('id', $request->tribe_id)->pluck('title')->first() . " successfully. users comments and answered points data is also deleted",

                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "Something went wrong",
                        // 'data' => $users,    
                    ],
                    200
                );
            }
        }
    }


    public function add_user_in_tribe(Request $request)
    {


        $input = $request->all();
        $rules = array(

            'user_id' => "required|numeric",
            'tribe_id' => "required|numeric",

        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        } else {
            $check_if_tribe = DB::table('tribes')->where('id', $request->tribe_id)->first();
            if (!isset($check_if_tribe) || $check_if_tribe == null) {
                return response()->json([
                    'code' => '422',
                    'message' => 'invalid tribe id'
                ], 422);
            }

            $check_if_user = DB::table('users')->where('id', $request->user_id)->first();
            if (!isset($check_if_user) || $check_if_user == null) {
                return response()->json([
                    'code' => '422',
                    'message' => 'invalid user id'
                ], 422);
            }

            // dd('validated');
            // $check = DB::table('user_tribes')->where('user_id' , '=' , $request->user_id)->where('tribe_id',$request->tribe_id)->first();
            // // dd($check);
            // if($check == null){
            $check = DB::table('user_tribes')->where('user_id', $request->user_id)->where('tribe_id', $request->tribe_id)->first();
            if ($check) {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "user already added",

                    ],
                    200
                );
            }

            $result = DB::table('user_tribes')->insert([
                'user_id' => $request->user_id,
                'tribe_id' => $request->tribe_id,
            ]);

            if ($result) {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "user added to tribe",
                        // 'data' => $users,    

                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'code' => '200',
                        'message' => "Something went wrong",
                        // 'data' => $users,    

                    ],
                    200
                );
            }
        }
    }

    public function add_user_to_tribe(Request $request)
    {
        $tribe_id = $request->tribe_id;
        // dd('walla');
        $check_if_tribe = DB::table('tribes')->where('id', $tribe_id)->first();
        if (!isset($check_if_tribe) || $check_if_tribe == null) {
            return response()->json([
                'code' => '403',
                'message' => 'invalid tribe id'
            ], 200);
        }


        $joined_users = DB::table('user_tribes')->where('tribe_id', '=', $tribe_id)->pluck('user_id');
        $users = DB::table('users')->where('user_role', 0)->whereNotIn('id', $joined_users)->where('is_leader', '=', '0')->select('name', 'email', 'image', 'id', 'is_leader')->get();

        return response()->json(
            [
                'code' => '200',
                'data' => $users,
                // 'data' => $data, 
            ],
            200
        );
    }


    public function get_article(Request $request)
    {
        $id = $request->id;

        $data = DB::table('articles')->find($id);

        if (!isset($data) || $data == null) {

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'invalid article id',
                    'error' => ' invalid article id'
                    // 'data' => $data, 
                ],
                200
            );
        } else {

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'success',
                    // 'error' => ' invalid article id'
                    'data' => $data,
                ],
                200
            );
        }
    }

    public function add_like(Request $request)
    {
        $id = $request->id;

        $check_comment_id = DB::table('discussions')->where('id', $id)->first();

        if ($check_comment_id) {

            $check =  DB::table('comment_likes')->where('comment_id', $id)->where('user_id', auth('api')->user()->id)->first();

            if ($check) {

                if ($check->is_like == 1) {

                    $cc = DB::table('comment_likes')->where('comment_id', $id)->where('user_id', auth('api')->user()->id)->delete();
                } else {
                    $cc = DB::table('comment_likes')->insert([
                        'is_like' => 1,
                        'user_id' => auth('api')->user()->id,
                        'updated_at' => carbon::now(),
                        'created_at' => carbon::now(),
                        'comment_id' => $id,
                        'is_dislike' => 0,

                    ]);
                }
            } else {

                $cc = DB::table('comment_likes')->insert([
                    'is_like' => 1,
                    'is_dislike' => 0,
                    'user_id' => auth('api')->user()->id,
                    'comment_id' => $id,
                    'created_at' => carbon::now(),
                ]);
            }

            $data = DB::table('discussions')->where('discussions.id', $id)->join('comment_likes', 'comment_likes.comment_id', '=', 'discussions.id')->get();
            foreach ($data as $row) {
                # code...
                if ($row->user_id == auth('api')->user()->id) {

                    if ($row->is_like == 1) {
                        $row->is_current_user_liked = true;
                    } else {
                        $row->is_current_user_liked = false;
                    }
                } else {
                    $row->is_current_user_liked = false;
                }


                $row->total_likes = DB::table('comment_likes')->where('comment_id', $id)->where('is_like', 1)->count();
            }





            return response()->json(
                [
                    'code' => '200',
                    'message' => 'like added',
                    'data' => $data,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '200',
                    'message' => 'wrong comment id',
                    'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
        }
    }



    public function delete_comment(Request $req)
    {
        $user=Auth::user();
        $comment_id=$req->comment_id;
        if(!Auth::check())
        {
            return response()->json(
                [
                    'code' => '200',
                    'message' => 'User Must Be authenticate',
                    // 'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
        }
        
        $comment_del = DB::table('discussions')->where('id', $comment_id)->delete();
        if ($comment_del) {
            DB::table('discussions')->where('parent_comment_id', $comment_id)->delete();
            DB::table('comment_likes')->where('comment_id', $comment_id)->delete();

            return response()->json(
                [
                    'code' => '200',
                    'message' => 'successfully deleted comment',
                    // 'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '200',
                    'message' => 'something went wrong',
                    'error' => 'error',
                    // 'data' => $data,    
                ],
                200
            );
        }
    }
    public function del_art(Request $request)
    {
        $art_id = $request->art_id;

        $del =  DB::table('articles')->where('id', $art_id)->delete();

        if ($del) {

            $coment_ids = DB::table('discussions')->where('article_id', $art_id)->pluck('id');
            DB::table('discussions')->where('article_id', $art_id)->delete();
            DB::table('comment_likes')->wherein('comment_id', $coment_ids)->delete();
            return response()->json(
                [
                    'code' => '200',
                    'message' => 'deleted successfully',
                    // 'error' => ' Comment not found',
                    // 'data' => $data,    
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '420',
                    'message' => 'Something went wrong',
                    'error' => 'something went wrong',
                    // 'data' => $data,    
                ],
                200
            );
        }
    }
    public function decline_join_request(Request $request)
    {
        $input = $request->all();
        $rules = array(

            'user_id' => "required|numeric",
            'tribe_id' => "required|numeric",

        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        // $id = $request->id;
        $join_request = DB::table('join_requests')->where('user_id', $request->user_id)->where('tribe_id', $request->tribe_id)->first();
        if ($join_request == null) {
            return response()->json([
                'error'   => 'invalid data',
                'message' => 'invalid data',
            ], 401);
        }
        $tribe = DB::table('tribes')->where('id', $join_request->tribe_id)->first();
        // send email to user:  
        // $input = $request->all();
        $user = DB::table('users')->where('id', $join_request->user_id)->first();
        $name = $user->name;
        $email = $user->email;
        $message_ = 'Sorry to inform you that your request to join  ' . $tribe->title . ' is declined by admin';
        $to_name = $name;
        $to_email = $email;
        $data = array(
            "name" => $name,
            "email" => $email,
            "message_" => $message_
        );



        try {




// /*from swift mailer*/
// $transport = new Swift_SmtpTransport(env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION'));
//                 $transport->setUsername(env('mail_username'));
//                 $transport->setPassword(env('MAIL_PASSWORD'));
//                 // echo '11dddd';exit;
//                 $swift_mailer = new Swift_Mailer($transport);
//                 Mail::setSwiftMailer($swift_mailer);
                $data = ["email" => $email ,"name" => $name , "title"=>strip_tags($tribe->title)];
                 $reciever_email = $email;
                 $sender_email = env('MAIL_FROM_ADDRESS');
                 $subject = 'Socrai Notification: Join Tribe Request Declined';

                Mail::send(['html'=>'emails.join-tribe-request-declined'], $data, function($message) use($reciever_email , $sender_email, $subject ) {
                    $message->to($reciever_email, 'Join Tribe Request Declined')->subject
                    ($subject);
                    $message->from($sender_email,$sender_email);
                });


/*from swift mailer*/







/*
            $message = '<html><body>';
            $message .= '<img style="background:black;" src="https://app.socrai.com/sucrai/assets/images/logo.png" alt="Website Change Request" />';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($to_name) . "</td></tr>";
            $message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($to_email) . "</td></tr>";


            $message .= "<tr><td><strong>Message :</strong> </td><td>Sorry to inform you that your request to join" . strip_tags($tribe->title) . " is declined by admin</td></tr>";

            // $message .= "<tr><td><strong>NEW Content:</strong> </td><td>" . htmlentities($_POST['newText']) . "</td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";


            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $from = 'noreply@socrai.com';
            $fromName = 'SOCRAI';
            // Additional headers 
            $headers .= 'From: ' . $fromName . '<' . $from . '>' . "\r\n";
            // $headers .= 'Cc: welcome@example.com' . "\r\n"; 
            // $headers .= 'Bcc: welcome2@example.com' . "\r\n";  

            mail($to_email, 'Request to join tribe is declined by admin', $message, $headers);
*/

            // mail($to_email,'Request to join tribe is declined by admin',$message_,'From : noreply@socrai.com');
            // $test = Mail::send('emails.request_decline', $data, function ($message) use ($to_name, $to_email) {
            //         $message->to($to_email, $to_name)->subject('Request to join tribe is declined by admin');
            //         $message->from('something@dev.socrai.com', 'Socrai');
            //       });

        } catch (\Exception $e) {
            DB::table('join_requests')->where('id', $join_request->id)->delete();
            return response()->json([
                'status'   => 'success',
                'message' => 'request declined, an error occured while sending email to user',
            ], 200);
        }
        DB::table('join_requests')->where('id', $join_request->id)->delete();
        return response()->json([
            'status'   => 'success',
            'message' => 'request declined',
        ], 200);
    }

    public function total_available_tribes()
    {
            $user=Auth::user();
            $user_id=$user->id;

        // $user = DB::table('users')->where('id', $user_id)->first();
        if ($user == null) {
            return response()->json(
                [
                    'code' => '403',
                    'status' => "error",
                    'message' => 'user not found'

                ],
                200
            );
        }

        $data = DB::table('users')
            ->join('user_tribes', 'users.id', '=', 'user_tribes.user_id')
            ->join('tribes', 'tribes.id', '=', 'user_tribes.tribe_id')
            ->join('articles', 'articles.tribe_id', '=', 'tribes.id')
            ->select('tribes.title', 'user_tribes.tribe_id')
            ->where('user_tribes.user_id', $user_id)
            ->get();
        // dd($data);
        $data = $data->unique('tribe_id');
        $thedtaa = array();
        foreach ($data as  $value) {
            # code...
            array_push($thedtaa, array(
                'title' => $value->title,
                'tribe_id' => $value->tribe_id,

            ));
        }
        // dd($thedtaa);

        if (count($data) > 0) {
            return response()->json(
                [
                    'code' => '200',
                    'status' => "success",
                    'message' => 'success',
                    'total_joined_tribes' => count($data),
                    'data' => $thedtaa
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'code' => '403',
                    'status' => "error",
                    'message' => 'user have not joined any tribe'

                ],
                200
            );
        }
    }
}
