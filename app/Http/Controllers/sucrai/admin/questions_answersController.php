<?php

namespace App\Http\Controllers\sucrai\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Log;
use Session;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Excel;
use App\Imports\ProjectsImport;
// use App\Exports\ProjectExport;
// use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class questions_answersController extends Controller
{
    public $destinationPath = '/media/questions_answers/';
    public $importArray = array();
    public function index()
    {

        // dd(pathinfo('https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_700KB.mp3', PATHINFO_EXTENSION));
        $questions = DB::table('question_answers')->orderBy('question_answers.type')->join('topics', 'question_answers.topic_id', '=', 'topics.id')->select('question_answers.*', 'topics.title');
        // $data = json_encode($questions);
        // $data = json_decode($data);
        foreach ($questions as $tc) {
            $linked = null;
            $linked = DB::table('question_exercise')->where('question_answer_id', '=', $tc->id)->pluck('exercise_question_id')->first();
            if ($linked != null) {
                $linked =  DB::table('question_answers')->where('id', $linked)->pluck('question')->first();
            }
            $top = DB::table('topics')->where('id', '=', $tc->topic_id)->pluck('title')->first();
            $tc->topic = $top;
            $tc->linked = $linked;
        }
        // dd($questions);
        // echo "<pre>";
        // print_r($questions);
        // exit;
        return view('admin.question-answers.home', compact('questions'));
    }
    public function index2()
    {

        // dd(pathinfo('https://file-examples-com.github.io/uploads/2017/11/file_example_MP3_700KB.mp3', PATHINFO_EXTENSION));
        $questions = DB::table('question_answers')->orderBy('question_answers.type')->join('topics', 'question_answers.topic_id', '=', 'topics.id')->select('question_answers.*', 'topics.title')->paginate(500);
        // dd($questions);
        $data = json_encode($questions);
        $data = json_decode($data);
        foreach ($questions as $tc) {
            $linked = null;
            $linked = DB::table('question_exercise')->where('question_answer_id', '=', $tc->id)->pluck('exercise_question_id')->first();
            if ($linked != null) {
                $linked =  DB::table('question_answers')->where('id', $linked)->pluck('question')->first();
            }
            $top = DB::table('topics')->where('id', '=', $tc->topic_id)->pluck('title')->first();
            $tc->topic = $top;
            $tc->linked = $linked;
        }
        // dd($questions);
        // echo "<pre>";
        // print_r($questions);
        // exit;
        return view('admin.question-answers.home-fast', compact('questions'));
    }

    function fetch_data(Request $request)
    {
        // dd('walla');

        if ($request->ajax()) {

            $query = $request->get('query');
            if ($query == null) {
                //  $questions = DB::table('question_answers')->orderBy('type','asc')->get()->take(50);

                // foreach ($questions as $tc) {
                //     $linked = null;
                //     $linked = DB::table('question_exercise')->where('question_answer_id', '=', $tc->id)->pluck('exercise_question_id')->first();
                //     if ($linked != null) {
                //         $linked =  DB::table('question_answers')->where('id', $linked)->pluck('question')->first();
                //     }
                //     $top = DB::table('topics')->where('id', '=', $tc->topic_id)->pluck('title')->first();
                //     $tc->topic = $top;
                //     $tc->linked = $linked;
                // }
                return 'refresh';
            } else {



                $query = str_replace(" ", "%", $query);
                $questions = DB::table('question_answers')->orderBy('question_answers.type')->join('topics', 'question_answers.topic_id', '=', 'topics.id')->select('question_answers.*', 'topics.title')
                    ->where('question_answers.question', 'like', '%' . $query . '%')
                    ->orWhere('question_answers.answer', 'like', '%' . $query . '%')
                    ->orWhere('question_answers.clue', 'like', '%' . $query . '%')
                    ->orWhere('topics.title', 'like', '%' . $query . '%')


                    // ->orWhere('answer', 'like', '%'.$query.'%')
                    // ->orWhere('answer', 'like', '%'.$query.'%')

                    // ->orWhere('post_description', 'like', '%'.$query.'%')
                    // ->orderBy($sort_by, $sort_type)
                    ->get();
                foreach ($questions as $tc) {
                    $linked = null;
                    $linked = DB::table('question_exercise')->where('question_answer_id', '=', $tc->id)->pluck('exercise_question_id')->first();
                    if ($linked != null) {
                        $linked =  DB::table('question_answers')->where('id', $linked)->pluck('question')->first();
                    }
                    $top = DB::table('topics')->where('id', '=', $tc->topic_id)->pluck('title')->first();
                    $tc->topic = $top;
                    $tc->linked = $linked;
                }
            }

            // html start

            // <tbody id="data_show">

            $counter = 1;

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


            $html = '';
            foreach ($questions as $row) {
                $style = '';
                if ($row->type == 1) {
                    $style = 'style="background : #D1D1D2"';
                }
                $html .=  '<tr ' . $style . ' >';
                $html .=  '<td style="display: none;">' . $counter . '</td>';
                $counter++;

                $html .=  '<td>' . $row->question . '</td>';
                $html .= '<td style="text-transform: none;">';


                if ($row->media_type == "external") {



                    $filetype = pathinfo($row->media, PATHINFO_EXTENSION);

                    if ($filetype == "mp3") {
                        $html .= '<img src="' . url('public/audio-placeholder.png') . '" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a' . $counter . '" href="javascript:;" />';
                        $html .= '<div style="display: none;" id="hidden-content-a' . $counter . '">';
                        $html .=   '<audio controls  autostart="0" autostart="false" preload ="none">
                                                <source src="' . $row->media . '" type="audio/mpeg">
                                                Your browser does not support the audio element
                                            </audio>
                                        </div>';
                    } else {
                        $html .= '<img src="' . url('public/play.png') . '" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a' . $counter . '" href="javascript:;" />';
                        $html .=  '<div style="display: none" id="hidden-content-a' . $counter . '">
                                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="500" height="300" src="' . $row->media . '"></iframe>
                                        </div>';
                    }
                    // @endif




                } else {

                    if (file_exists(public_path($row->media))) {

                        if (in_array($row->media_type, $image_type)) {


                            $html .= '<a href="' . url('public/' . $row->media) . '" data-fancybox="images" data-caption="">
                                    <img src="' . url('public/' . $row->media) . '" style="width:50px" />
                                </a>';
                        } elseif (in_array($row->media_type, $video_type)) {

                            $html .=  '<img src="public/play.png" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a' . $counter . '" href="javascript:;" />';
                            $html .=   '<div style="display: none;" id="hidden-content-a' . $counter . '">
                                    <video controls poster="public/play.png" width="320" height="240">';
                            $html .=   '<source src="public' . $row->media . '" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>';
                        } elseif (in_array($row->media_type, $audio_type)) {
                            $html .= '<img src="url("public/audio-placeholder.png")" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a' . $counter . '" href="javascript:;" />
                                    <div style="display: none;" id="hidden-content-a' . $counter . '">';
                            $html .=  '<audio controls  autostart="0" autostart="false" preload ="none">
                                            <source src=" url(/public' . $row->media . ')" type="audio/mpeg">';
                            $html .= 'Your browser does not support the audio element.
                                        </audio>
                                    </div>';
                        }
                    }
                }

                $html .= '</td>';
                $html .= '<td>' .
                    $row->answer

                    . '</td>';


                $html .=  '<td>' . $row->clue . '</td>';
                $html .= '<td>';
                if ($row->type == 1) {
                    $html .= 'Exercise';
                } else {
                    $html .= 'Question';
                }


                $html .= '</td>';
                $html .=  '<td>' . $row->topic . '</td>';
                $html .= '<td>' . $row->level . '</td>';
                $html .= '<td>';
                if ($row->type == 0) {


                    if ($row->linked == null && $row->type != 1) {

                        $html .=   '<table class="table-bordered table">
                                    <tbody>
                                        <tr>
                                            <td> <a href="' . url('/questions_answers/addToExercise/' . $row->id) . '" class="btn btn-sm btn-warning text-center" style="float: left;"><i class="fa fa-paperclip" aria-hidden="true"></i> Attach To Exercise </a> </td>
                                        </tr>
                                        <tr>
                                            <td> <a href="' . url('/questions_answers/makeItExercise/' . $row->id) . '" class="btn btn-sm btn-dark text-center" style="float: left;"><i class="fa fa-check-circle" aria-hidden="true"></i> Make It Exercise </a></td>
                                        </tr>
                                    </tbody>
                                </table>';
                    } elseif ($row->linked != null && $row->type != 1) {
                        $html .= '<table class="table-bordered table">
                                    <tbody>
                                        <tr>
                                            <th> <strong>Attached to :</strong> </th>
                                        </tr>
                                        <tr>
                                            <td>' . $row->linked . '</td>
                                        </tr>
                                        <td colspan="2">
                                            <a href="' . url('/questions_answers/makeItExercise/' . $row->id) . '" class="btn btn-sm btn-dark text-center" style="float: left;"><i class="fa fa-star"></i> Make it exercise </a>
                                        </td>
                                    </tbody>
                                </table>';
                    }
                } else {
                    $html .=     '<a href="' . url('/questions_answers/removefromExercise/' . $row->id) . '" class="btn btn-sm btn-danger text-center" style="float: left;"><i class="fa fa-times-circle" aria-hidden="true"></i> Remove From Execise </a>';
                }




                $html .= ' </td>

                            <td class="text-center">
                                <div class="actions-btns dule-btns float-lg-right">

                                    <a href="' . url('/questions_answers/edit/' . $row->id) . '" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i></a>


                                </div>
                            </td>';




                $html .= '</tr>';
            }



            return $html;
        }
    }




    public function add()
    {
        $topics = DB::table('topics')->get();
        return view('admin.question-answers.add', compact('topics'));
    }
    /**
     * Store question and answers.
     */
    public function store(Request $request)
    {
        $fileName = '';
        $media_type = '';
        // check media type
        if (isset($request->media) && $request->media == "upload_media" && $request->hasFile('upload')) {


            $request->validate([
                // 'upload' => 'required|mimes:image/jpeg,image/png,image/jpg,image/gif,vide/mp4,audio/mp3|max:10000'
                // 'upload' => 'required|max:10000'
                'upload' => 'max:10000'
            ]);

            $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'audio/mp3', 'audio/mpeg');
            $uploadfile = $request->file('upload');
            $mmtype = $uploadfile->getMimeType();

            // exit( $mmtype );


            if (!in_array($mmtype, $allowed_file_types)) {
                Session::flash('Failed', 'File type not allowed.Allowed file types are jpeg,png,jpg,gif,mp4,mp3');
                return redirect("questions_answers/add");
            }


            if ($request->hasFile('upload')) {

                // $validation = $request->validate([
                //     // 'upload' => 'required|mimes:image/jpeg,image/png,image/jpg,image/gif,vide/mp4,audio/mp3|max:10000'
                //     'upload' => 'required|mimes:jpeg,png,jpg,gif,mp4,mp3|max:10000'
                // ]);

                $file = $request->file('upload');
                $fileName = date('d_m_y') . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->destinationPath), $fileName);

                $fileName = $this->destinationPath . $fileName;
                $media_type = pathinfo($fileName, PATHINFO_EXTENSION);
            }
        } elseif (isset($request->media) && $request->media == "external_media") {
            // $fileName = isset($request->external_media) ? $request->external_media : "";
            // $media_type = "external";

            $request->validate([
                'external_media' => 'required'
            ]);

            $url = isset($request->external_media) ? trim($request->external_media) : "";

            // if mp3 video
            $filetype = pathinfo($url, PATHINFO_EXTENSION);
            $video_link = $this->getYoutubeVideoID($url);

            if (gettype($video_link) !== "boolean") {  // if youtube video
                $fileName = $video_link;
            } else {

                // check if external media is a mp3
                if ($filetype == "mp3") {
                    $fileName = $url;
                } else {
                    Session::flash('Failed', 'External media must be a valid youtube or mp3 link');
                    return redirect("questions_answers/add");
                }
            }

            $media_type = "external";
        }

        // dd($fileName);
        // dd($request->all());
        $question_input_type =  isset($request->questiontype) ? $request->questiontype : 0;
        // dd($question_input_type);

        $questions_count = count(DB::table('question_answers')->where('topic_id', '=', $request->topic_id)->where('level', '=', $request->level)->where('type', 0)->get());
        $questions_count_E = count(DB::table('question_answers')->where('topic_id', '=', $request->topic_id)->where('level', '=', $request->level)->where('type', 1)->get());



        if ($question_input_type == 0) {
            if ($request->level == 1) {
                if ($questions_count < 18) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Question');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 18 questions of this level ');
                    return redirect("questions_answers/add");
                }
            } elseif ($request->level == 2) {
                if ($questions_count <= 53) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Question ');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 54 questions of this level ');
                    return redirect("questions_answers/add");
                }
            } elseif ($request->level == 3) {
                if ($questions_count < 162) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Question ');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 164 questions of this level ');
                    return redirect("questions_answers/add");
                }
            } else {
                Session::flash('Failed', 'Invalid Input');
                return redirect("questions_answers/add");
            }
        } else {
            if ($request->level == 1) {
                if ($questions_count_E < 18) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Exercise');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 18 exercises of this level ');
                    return redirect("questions_answers/add");
                }
            } elseif ($request->level == 2) {
                if ($questions_count_E <= 53) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Exercise ');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 54 exercises of this level ');
                    return redirect("questions_answers/add");
                }
            } elseif ($request->level == 3) {
                if ($questions_count_E < 162) {
                    $result = DB::table('question_answers')->insert([
                        'question' => $request->question,
                        'answer' => $request->answer,
                        'clue' => $request->clue,
                        'topic_id' => $request->topic_id,
                        'level' => $request->level,
                        'type' => isset($request->questiontype) ? $request->questiontype : 0,
                        'media' => $fileName,
                        'media_type' => $media_type,
                    ]);
                    Session::flash('success', 'Successfully Added Exercise ');
                    return redirect("questions_answers/add");
                } else {
                    Session::flash('Failed', 'You can only add 164 exercises of this level ');
                    return redirect("questions_answers/add");
                }
            } else {
                Session::flash('Failed', 'Invalid Input');
                return redirect("questions_answers/add");
            }
        }

        // 

    }
    public function edit($id)
    {
        // dd('wala');
        // $un_linked_question = DB::table('question_answers')->find($id);
        $all_exercises = DB::table('question_exercise')->pluck('exercise_question_id');
        $exercise = DB::table('question_answers')->where('type', 1)->whereNotIn('id', $all_exercises)->get();
        // dd($exercise);
        $attach_flag = DB::table('question_exercise')->where('question_answer_id', $id)->first();
        if ($attach_flag != null) {
            $attach_flag->question = DB::table('question_answers')->where('id', $attach_flag->exercise_question_id)->pluck('question')->first();
        }
        $data = DB::table('question_answers')->find($id);
        $data->question_id = $id;
        $selected_topic = DB::table('topics')->where('id', $data->topic_id)->pluck('title')->first();
        $data->current_topic = $selected_topic;
        $topic = DB::table('topics')->get();
        $data->topic = $topic;
        // dd($data);
        return view('admin.question-answers.edit', compact('data', 'id', 'exercise', 'attach_flag'));
    }

    /**
     * Update Question and Answer
     */
    public function update(Request $request)
    {

        $fileName = '';
        $media_type = '';

        // check media type
        if (isset($request->media) && $request->media == "upload_media" && $request->hasFile('upload')) {

            $request->validate([
                // 'upload' => 'required|max:10000'
                'upload' => 'max:10000'
            ]);

            $allowed_file_types = array('image/jpg', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'video/mp4', 'audio/mp3', 'audio/mpeg');
            $uploadfile = $request->file('upload');
            $mmtype = $uploadfile->getMimeType();
            if (!in_array($mmtype, $allowed_file_types)) {
                Session::flash('Failed', 'File type not allowed.Allowed file types are jpeg,png,jpg,gif,mp4,mp3');
                //redirect("questions_answers/edit/"+$request->id);
				return redirect("questions_answers/edit/".$request->id);
				//return redirect()->back();
            }


            if ($request->hasFile('upload')) {
                // $request->validate([
                //     'upload' => 'required|mimes:image/jpeg,image/png,image/jpg,image/gif,vide/mp4,audio/mp3|max:10000'
                // ]);
                $file = $request->file('upload');
                $fileName = date('d_m_y') . '_' . time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($this->destinationPath), $fileName);

                $fileName = $this->destinationPath . $fileName;
                $media_type = pathinfo($fileName, PATHINFO_EXTENSION);
            }
        } elseif (isset($request->media) && $request->media == "external_media") {
            // $fileName = isset($request->external_media) ? $request->external_media : "";
            // $media_type = "external";

            $request->validate([
                'external_media' => 'required'
            ]);

            $url = isset($request->external_media) ? trim($request->external_media) : "";

            // if mp3 video
            $filetype = pathinfo($url, PATHINFO_EXTENSION);
            $video_link = $this->getYoutubeVideoID($url);

            if (gettype($video_link) !== "boolean") {  // if youtube video
                $fileName = $video_link;
            } else {

                // check if external media is a mp3
                if ($filetype == "mp3") {
                    $fileName = $url;
                } else {

                    Session::flash('Failed', 'External media must be a valid youtube or mp3 link');
                    return redirect()->back();
                }
            }

            $media_type = "external";
        }

        if (isset($request->check_exercise_question)) {
            if ($request->check_exercise_question == 1  && $request->exercise_question != null) {
                $check_question_has_exercise = DB::table('question_exercise')->where('question_answer_id', $request->id)->first();
                if ($check_question_has_exercise == null) {
                    $result = DB::table('question_exercise')->insert([
                        "question_answer_id" => $request->id,
                        "exercise_question_id" => $request->exercise_question
                    ]);
                } elseif ($check_question_has_exercise != null) {
                    $result = DB::table('question_exercise')->where('question_answer_id', $request->id)->update([
                        "question_answer_id" => $request->id,
                        "exercise_question_id" => $request->exercise_question
                    ]);
                }
            }
        } elseif (!isset($request->check_exercise_question)) {
            $delete_question = DB::table('question_exercise')->where('question_answer_id', $request->id)->delete();
        }

        // $questions_count = count(DB::table('question_answers')->where('topic_id', '=', $request->topic_id)->where('level', '=', $request->level)->get());



        // if ($request->level == 1) {
        // if ($questions_count < 18) {

        if (!empty($fileName)) {
            DB::table('question_answers')->where('id', $request->id)->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'clue' => $request->clue,
                'topic_id' => $request->topic_id,
                'level' => $request->level,

                'media' =>  $fileName,
                'media_type' => $media_type,
            ]);
        } else {
            DB::table('question_answers')->where('id', $request->id)->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'clue' => $request->clue,
                'topic_id' => $request->topic_id,
                'level' => $request->level,
            ]);
        }

        Session::flash('success', 'Successfully Updated Question ');
        return redirect()->route('questions_answers');
        //     } else {
        //         Session::flash('Failed', 'You can only add 18 questions of this level ');
        //         return redirect()->route('questions_answers');
        //     }
        // } elseif ($request->level == 2) {
        //     if ($questions_count <= 53) {

        //         if (!empty($fileName)) {
        //             $result = DB::table('question_answers')->where('id', $request->id)->update([
        //                 'question' => $request->question,
        //                 'answer' => $request->answer,
        //                 'clue' => $request->clue,
        //                 'topic_id' => $request->topic_id,
        //                 'level' => $request->level,

        //                 'media' => $fileName,
        //                 'media_type' => $media_type,

        //             ]);
        //         } else {

        //             DB::table('question_answers')->where('id', $request->id)->update([
        //                 'question' => $request->question,
        //                 'answer' => $request->answer,
        //                 'clue' => $request->clue,
        //                 'topic_id' => $request->topic_id,
        //                 'level' => $request->level,
        //             ]);
        //         }

        //         Session::flash('success', 'Successfully Updated Question ');
        //         return redirect()->route('questions_answers');
        //     } else {
        //         Session::flash('Failed', 'You can only add 54 questions of this level ');
        //         return redirect()->route('questions_answers');
        //     }
        // } elseif ($request->level == 3) {
        //     if ($questions_count < 162) {

        //         if (!empty($fileName)) {

        //             $result = DB::table('question_answers')->where('id', $request->id)->update([
        //                 'question' => $request->question,
        //                 'answer' => $request->answer,
        //                 'clue' => $request->clue,
        //                 'topic_id' => $request->topic_id,
        //                 'level' => $request->level,

        //                 'media' => $fileName,
        //                 'media_type' => $media_type,
        //             ]);
        //         } else {

        //             $result = DB::table('question_answers')->where('id', $request->id)->update([
        //                 'question' => $request->question,
        //                 'answer' => $request->answer,
        //                 'clue' => $request->clue,
        //                 'topic_id' => $request->topic_id,
        //                 'level' => $request->level,
        //             ]);
        //         }
        //         Session::flash('success', 'Successfully Updated Question ');
        //         return redirect()->route('questions_answers');
        //     } else {
        //         Session::flash('Failed', 'You can only add 164 questions of this level ');
        //         return redirect()->route('questions_answers');
        //     }
        // } else {
        //     Session::flash('Failed', 'Invalid Input');
        //     return redirect()->route('questions_answers');
        // }
    }
    // ahmad controllers
    public function addtoexercise($id)
    {
        $question = DB::table('question_answers')->find($id);
        // dd($question);
        $all_exercises = DB::table('question_exercise')->pluck('exercise_question_id');
        $exercise = DB::table('question_answers')->where('type', 1)->whereNotIn('id', $all_exercises)->where('topic_id', $question->topic_id)->get();
        return view('admin.question-answers.add-to-exercise', compact('exercise', 'id'));
    }
    public function storeExerciseQuestion(Request $request)
    {
        // dd($request->all());
        $result = DB::table('question_exercise')->where('question_answer_id', $request->question_id)->first();
        // dd($result);
        if ($result != null) {
            Session::flash('Failed', 'This Question Already attached to exercise');
            return redirect()->route('questions_answers');
        } else {
            $flag = DB::table('question_exercise')->where('exercise_question_id', $request->exercise_id)->get();
            // dd();    
            // dd(count($flag));  
            if (count($flag) > 0) {
                Session::flash('Failed', 'This Exercise Already have an Question to Exercise');
                return redirect()->route('questions_answers');
            }
            $data = DB::table('question_exercise')->insert([
                "question_answer_id" => $request->question_id,
                "exercise_question_id" => $request->exercise_id
            ]);
            Session::flash('success', 'Question is attached to Exercise');
            return redirect()->route('questions_answers');
        }
    }
    public function removefromexercise($id)
    {
        // dd($id);
        DB::table('question_answers')->where('id', $id)->update([
            "type" => 0,
        ]);
        DB::table('question_exercise')->where('exercise_question_id', $id)->delete();
        //return redirect()->back();
		return redirect("questions_answers");
    }
    public function makeItExercise($id)
    {
        DB::table('question_answers')->where('id', $id)->update([
            "type" => 1,
        ]);
        DB::table('question_exercise')->where('question_answer_id', $id)->delete();
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $id = $request->input("id");
        $question = DB::table('question_answers')->where('id', $id)->first();

        if ($question->media_type == "external") {
            // null media field
        } elseif ($question->media_type != "external") {

            $media_path = public_path($question->media);

            if (file_exists($media_path)) {
                @unlink($media_path);
            }

            // dd("deleteed question and answers");

        }




        if ($question->type == 0) {
            DB::table('question_exercise')->where('question_answer_id', $id)->delete();
        } else {
            DB::table('question_exercise')->where('exercise_question_id', $id)->delete();
        }
        DB::table('topics')->where('id', $id)->delete();
        DB::table('user_questions')->where('question_answer_id', $id)->delete();
        DB::table('question_answers')->where('id', $id)->delete();
    }
    /**
     * Show import sceen
     */
    public function getImport()
    {
        $topic = DB::table('topics')->get();
        return View('admin/question-answers/import', compact('topic'));
    }
    /**
     * Store Import data
     */

    public function store_csv(Request $request)
    {
        dd($request);
    }


    public function addMedia()
    {
        // dd('add media');  
        $topic = DB::table('topics')->get();
        return View('admin/question-answers/add-media', compact('topic'));
    }
    public function media_index()
    {
        $user = auth()->user()->id;
        $data  = DB::table('media_types')->where('user_id', $user)->orderBy('topic_id')->get();

        return view('admin/question-answers/media_home', compact('data'));
    }
    public function destroy_media(Request $request)
    {
        $id = $request->input("id");
        $media = DB::table('media_types')->where('id', $id)->first();
        $media_file  = '/media/questions_answers/' . $media->file;
        $questions_with_this_media = DB::table('question_answers')->where('media_type', '!=', 'external')->where('media', $media_file)->update([
            'media' => '',
            'media_type' =>  '',

        ]);

        $media_path = public_path('media/questions_answers/' . $media->file);

        if (file_exists($media_path)) {
            @unlink($media_path);
        }

        $mediaa = DB::table('media_types')->where('id', $id)->delete();
    }
    public function    storeInternalMediaQuestions(Request $request)
    {
        // dd($request);
        $count = 0;
        foreach ($request->question as $value) {
            # code...
            $media = DB::table('media_types')->where('user_id', auth()->user()->id)->where('id', $request->media[$count])->first();
            // $question = DB::table('question_answers')->where('id' , $request->q[$count])->first();
            DB::table('question_answers')->where('id', $request->q[$count])->update([
                "media" => '/media/questions_answers/' . $media->file,
                "media_type" => $media->mediatype,

            ]);

            $count++;
        }

        // redirect("questions_answers/import");
        return redirect()->route('questions_answers');
    }

    public function storeMedia(Request $request)
    {
        // dd($request->topic);

        $ses_err_message = "";

        $this->validate($request, [
            'file' => 'required',
            'topic' => 'required',
        ]);

        if ($request->hasFile('file')) {
            $allowedfileExtension = ['mp4', 'jpg', 'JPG', 'png', 'mp3'];
            // dd($allowedfileExtension);
            $files = $request->file('file');
            foreach ($files as $file) {
                $filename = date('d_m_y') . '_' . time() . '_' . $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                // dd($extension);
                $check = in_array($extension, $allowedfileExtension);
                // dd($check);
                if ($check == false) {
                    $ses_err_message .= $extension . ' extension is not supported' . ';';
                    continue;
                }
                if ($check) {

                    if ($extension != 'mp4') {

                        $file->move(public_path('media/questions_answers'), $filename);
                    } else {
                        $file->move(public_path('media/questions_answers'), $filename);
                    }



                    DB::table('media_types')->insert([
                        "user_id" => auth()->user()->id,
                        "file" => $filename,
                        "mediatype" => $extension,
                        "topic_id" => $request->topic,


                    ]);
                }
            }
        }

        Session::flash('question_import_error',  $ses_err_message);
        return redirect()->route('home.media');
    }
    function getCellStyles($cell)
    {
        if (!method_exists($cell, 'getStyle')) {
            return false;
        }

        $getStyle = $cell->getStyle();

        $fill      = $getStyle->getFill();
        $font      = $getStyle->getFont();
        $borders   = $getStyle->getBorders();
        $alignment = $getStyle->getAlignment();

        return [
            'fill'      => [
                'color' => $fill->getFillType() == 'none' ? '' : $fill->getStartColor()->getRGB(),
                'filled' => $fill->getFillType(),
            ],
            'font'      => [
                'name'  => $font->getName(),
                'size'  => $font->getSize(),
                'color' => $font->getColor()->getRGB(),
                'fontWeight' => $font->getBold()
            ],
            'borders'   => [
                'left'   => [
                    'color'     => $borders->getLeft()->getColor()->getRGB(),
                    'thickness' => $borders->getLeft()->getBorderStyle(),
                ],
                'right'  => [
                    'color'     => $borders->getRight()->getColor()->getRGB(),
                    'thickness' => $borders->getRight()->getBorderStyle(),
                ],
                'top'    => [
                    'color'     => $borders->getTop()->getColor()->getRGB(),
                    'thickness' => $borders->getTop()->getBorderStyle(),
                ],
                'bottom' => [
                    'color'     => $borders->getBottom()->getColor()->getRGB(),
                    'thickness' => $borders->getBottom()->getBorderStyle(),
                ],
            ],
            'alignment' => [
                'horizontal' => $alignment->getHorizontal(),
                'vertical'   => $alignment->getVertical(),
                'wrap'       => $alignment->getWrapText(),
                'shrink'     => $alignment->getShrinkToFit(),
                'indent'     => $alignment->getIndent(),
            ],
        ];
    }
    public function importQuestionsAnswers(Request $request)
    {
        // dd($request);
        request()->validate([
            'file' => 'required|mimes:xls'
        ]);
        $path = request()->file('file')->getRealPath();
        $path1 = request()->file('file')->store('temp');
        $path = storage_path('app').'/'.$path1;
        // dd($path);
        // $csvArrr = $this->csvToArray($path);
        $csvArrr =  Excel::toArray(new ProjectsImport, $path);
        
        // $file=$request->file('file')->store('import');
        // $csvArrr =  Excel::toArray(new ProjectsImport, $path);
        // $excel = Excel::import(new ProjectsImport, $path);
        // $sheet = $excel->first();

        // (new ProjectsImport)->import($fil

        // $csvArrr =  Excel::import(\Maatwebsite\Excel\Concerns\ToModel,$path);
        // dd($csvArrr);
        // dd($csvArrr);
        $csvArrr = $csvArrr[0]; 
        $ses_err_message = "";
        $user_id = auth()->user()->id;

        $exercise_in_csv;
        $media_type_i_questions;

        $missing_entry_check = 'true';
        $sec_check = 'false';


        $indexes = array_keys($csvArrr[0]);
        // dd($indexes);

        if (($indexes[0] != 'serial')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[1] != 'question')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[2] != 'answer')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[3] != 'clue')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[4] != 'level')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[5] != 'type')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[6] != 'media')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[7] != 'media_type')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }

        if (($indexes[8] != 'linked')) {

            $sec_check = 'true';
            $missing_entry_check = 'false';
        }


        if ($sec_check == 'true') {
            $missing_entry_check = 'false';
        }


        if ($missing_entry_check == 'false') {
            $ses_err_message .= 'please provide proper header fields in EXCEL file to import Question/Answers, Or <a href="' . url('/questions_answers/csv/sample') . '"> click here  </a> to download sample XLS file;';
        }
        $imported_questions_count = 0;
        $imported_exe_count = 0;

        // dd($csvArrr);
        foreach ($csvArrr as $datum) {

            if ($missing_entry_check == 'false') {
                break;
            }

            if (!isset($datum['serial'])) {
                $ses_err_message .= 'serial field is undefined ; ';
                continue;
            }
            if (!isset($datum['question']) ||    $datum['question'] == '') {
                $ses_err_message .= 'question field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }
            if (!isset($datum['answer'])    ||    $datum['answer'] == '') {
                $ses_err_message .= 'answer field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }
            if (!isset($datum['clue'])   ||    $datum['clue'] == '') {
                $ses_err_message .= 'clue field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }
            if (!isset($datum['level'])   ||    $datum['level'] == '') {
                $ses_err_message .= 'level field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }
            if ((int)$datum['level'] > 3 || (int)$datum['level'] < 1) {
                $ses_err_message .= 'level must be 1-3 in range ;';
                continue;
            }
            if (!isset($datum['type'])     ||    $datum['type'] == '') {
                $ses_err_message .= 'type field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }

            if ($datum['media_type'] == 'E' &&      $datum['media'] == '') {
                $ses_err_message .= 'Media field is undefined for serial # ' . $datum['serial'] . ';';
                continue;
            }


            $media = null;
            $media_type = null;
            $q_type = null;
            $url = '';
            $filetype = '';
            $video_link = '';
            // "" => 
            $check_exist = DB::table('question_answers')->where('question', $datum['question'])->where('topic_id', $request->topic)->first();
            if ($check_exist != null) {
                $ses_err_message .= 'Question ' . $datum['question'] . ' is already exists ;';
                continue;
            }



            if ($datum['type'] == 'E') {
                $exercise_in_csv[] = $datum;
            }



            if ($datum['media_type'] == 'I') {
                $media_type_i_questions[] = $datum['question'];
            }


            if ($datum['media_type'] == 'I') {
                $media = ' ';
                $media_type = ' ';
                // $topic = '0'; 
            } elseif ($datum['media_type'] == 'E') {
                $media = $datum['media'];
                // $media_type = 'external';




                // external
                $url = $media;

                // if mp3 video
                $filetype = pathinfo($url, PATHINFO_EXTENSION);
                $video_link = $this->getYoutubeVideoID($url);

                if (gettype($video_link) !== "boolean") {  // if youtube video
                    $fileName = $video_link;
                } else {

                    // check if external media is a mp3
                    if ($filetype == "mp3") {
                        $fileName = $url;
                    }
                }

                $media_type = "external";
                $media = $fileName;
            } else {
                $media = '';
                $media_type = '';
            }


            if ($datum['type'] == 'E') {
                $q_type = '1';
            } else {
                $q_type = '0';
            }



            $topic_id  = $request->topic;
            $level = $datum['level'];
            $can_store  = 0;
            $questions_count = count(DB::table('question_answers')->where('topic_id', '=', $topic_id)->where('level', '=', $level)->where('type', 0)->get());
            $questions_count_E = count(DB::table('question_answers')->where('topic_id', '=', $topic_id)->where('level', '=', $level)->where('type', 1)->get());



            if ($q_type == 0 || $datum['type'] == 'Q') {
                if ($level == 1) {
                    if ($questions_count < 18) {
                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } elseif ($level == 2) {
                    if ($questions_count <= 53) {

                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } elseif ($level == 3) {
                    if ($questions_count < 162) {
                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } else {

                    $can_store  = 0;
                }
            } elseif ($q_type == 1 || $datum['type'] == 'E') {
                if ($level == 1) {
                    if ($questions_count_E < 18) {
                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } elseif ($level == 2) {
                    if ($questions_count_E <= 53) {

                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } elseif ($level == 3) {
                    if ($questions_count_E < 162) {
                        $can_store  = 1;
                    } else {
                        $can_store  = 0;
                    }
                } else {

                    $can_store  = 0;
                }
            } else {
                $can_store == 0;
            }


            if ($can_store == 0) {
                $ses_err_message .= 'Maximum questions are added for  level # ' . $datum['level'] . ', question ' . $datum['question'] . ' is not added.' . ';';
                continue;
            }

            // $ses_err_message.=$datum['question'];
            
            // if($datum['question_style']["font"]["fontWeight"] == true){
            //     $datum['question'] = '<strong>'.$datum['question'].'</strong>';
            // }
            // if($datum['answer_style']["font"]["fontWeight"] == true){
            //     $datum['answer'] = '<strong>'.$datum['answer'].'</strong>';
            // }
            $r = DB::table('question_answers')->insert([
                "question" => str_replace('"', '\"', $datum['question']),
                "answer" => str_replace('"', '\"', str_replace("\n", "<br>", $datum['answer'])),
                "clue" => $datum['clue'],
                "media" => $media,
                "type" => $q_type,
                "media_type" => $media_type,
                "level" => $datum['level'],
                "topic_id" => $request->topic,

            ]);
            if ($r) {
                $imported_questions_count++;
            }
        }



        if (isset($exercise_in_csv)) {
            foreach ($exercise_in_csv as $exe) {
                $question = null;
                if (!isset($exe['linked'])) {
                    continue;
                }


                foreach ($csvArrr as $csvarray) {

                    if ($csvarray['serial'] == $exe['linked']) {
                        $question = $csvarray['question'];
                        break;
                    }
                }

                $exercise = DB::table('question_answers')->where('question', $exe['question'])->where('topic_id', $request->topic)->pluck('id')->first();
                $linked_question  = DB::table('question_answers')->where('question', $question)->where('topic_id', $request->topic)->pluck('id')->first();
                if (!isset($linked_question)) {
                    continue;
                }
                // echo $exercise . "---" . $linked_question; 
                $check_already_linked = DB::table('question_exercise')->where('exercise_question_id', '=',  $exercise)->first();
                if ($check_already_linked != null) {
                    continue;
                }

                $check_already_linked = DB::table('question_exercise')->where('question_answer_id', '=', $linked_question)->first();
                if ($check_already_linked != null) {
                    continue;
                }
                $popo = DB::table('question_exercise')->insert([
                    "question_answer_id" => $linked_question,
                    "exercise_question_id" => $exercise

                ]);

                if ($popo) {
                    $imported_exe_count++;
                }




                // exit();	

            }
        }
        $error_messege_array = explode(',', $ses_err_message);

        // imported_questions_count
        $ses_err_message .= $imported_questions_count . ' Questions imported successfully ;';

        $ses_err_message .= $imported_exe_count . ' Exercises linked successfully ;';

        // dd($error_messege_array);

        // dd($media_type_i_questions);
        if (isset($media_type_i_questions)) {
            $all_questions_with_media_type_i = DB::table('question_answers')->wherein('question', $media_type_i_questions)->where('topic_id', $request->topic)->get();


            $media = DB::table('media_types')->where('user_id', auth()->user()->id)->where('topic_id', $request->topic)->get();
            if (count($media) > 0) {
                $topic_name = DB::table('topics')->where('id', $request->topic)->pluck('title')->first();
                Session::flash('question_import_error',  $ses_err_message);
                return view('admin.question-answers.imported-questions', compact('csvArrr', 'media', 'user_id', 'ex_questions', 'topic_name', 'all_questions_with_media_type_i', 'topic'));
            } else {
                $ses_err_message .= 'No media attached in this topic, <a href="' . route('home.media') . '"> click here  </a>  to Add media';
                Session::flash('question_import_error',  $ses_err_message);
                return redirect()->route('questions_answers');
            }
        } else {
            Session::flash('question_import_error',  $ses_err_message);
            return redirect()->route('questions_answers');
        }






        Session::flash('question_import_error',  $ses_err_message);

        // $csvArr = DB::table('temp_import_questions')->where('user_id' , $user_id)->get();
        // $ex_questions = [];
        // foreach ($csvArr as $ex_q) {
        //     if($ex_q->question_type == 'E'){
        //           $ex_questions[] = $ex_q->question;
        //     }
        // }

        // $ex_questions = json_encode($ex_questions);




        return view('admin.question-answers.imported-questions', compact('csvArr', 'user_id', 'ex_questions'));


        // dd($csvArr);

        // get excercise
        $exeArr = Arr::where($csvArr, function ($value, $key) {
            return $value['type'] == 'E';
        });

        $quesArr = Arr::where($csvArr, function ($value, $key) {
            return $value['type'] == 'Q';
        });

        //ECHO "<PRE>";
        //dd(PRINT_R($exeArr).'-----------'. PRINT_R($quesArr) );

        if (count($exeArr) > 0) {
            foreach ($exeArr as $row) {
                if (Db::table('question_answers')->where('question', '=', $row['question'])->exists())
                    continue;

                // type
                $type = trim($row['type']);
                $question_type = 1;
                // answer
                $answer = trim($row['answer']);
                $answer = str_replace(",", "\,", $answer);

                $fileName = "";
                $media = "";
                $media_type = "";
                $uploaded_path = "";

                $media = trim($row['media']);
                $media_type = trim($row['media_type']);

                // media
                if (isset($row['media_type']) && $row['media_type'] == "I") {
                    $uploaded_path = url($media);
                    $fileName = $media;
                    // internal 
                    $media_type = pathinfo($uploaded_path, PATHINFO_EXTENSION);
                } elseif (isset($row['media_type']) && $row['media_type'] == "E") {
                    // external
                    $url = $media;

                    // if mp3 video
                    $filetype = pathinfo($url, PATHINFO_EXTENSION);
                    $video_link = $this->getYoutubeVideoID($url);

                    if (gettype($video_link) !== "boolean") {  // if youtube video
                        $fileName = $video_link;
                    } else {

                        // check if external media is a mp3
                        if ($filetype == "mp3") {
                            $fileName = $url;
                        }
                    }

                    $media_type = "external";
                }

                $data = array(
                    'question'  => trim($row['question']),
                    'answer'    => $answer,
                    'clue'      => trim($row['clue']),
                    'level'     => trim($row['level']),
                    'type'      => $question_type,
                    'media'     => $fileName,
                    'media_type' => $media_type,
                );

                // DB::table('question_answers')->insert($data);
                $exeId = DB::table('question_answers')->insertGetId($data);
                //insert excercise

                $Serial = $row['serial'];

                //Log::info('out '.$Serial);
                $exeQuesArr = Arr::where($quesArr, function ($value, $key) use ($Serial) {
                    //Log::info('in '.$Serial);

                    return $value['linked'] == $Serial;
                });

                //Log::info('1234 '.$Serial.count($exeQuesArr));
                //DD();

                if (count($exeQuesArr) == 0)
                    continue;

                foreach ($exeQuesArr as $row) {
                    if (Db::table('question_answers')->where('question', '=', $row['question'])->exists())
                        continue;

                    Log::info('1234 ' . $Serial);

                    // type
                    $type = trim($row['type']);
                    $question_type = 0;
                    // answer
                    $answer = trim($row['answer']);
                    $answer = str_replace(",", "\,", $answer);

                    $fileName = "";
                    $media = "";
                    $media_type = "";
                    $uploaded_path = "";

                    $media = trim($row['media']);
                    $media_type = trim($row['media_type']);

                    // media
                    if (isset($row['media_type']) && $row['media_type'] == "I") {
                        $uploaded_path = url($media);
                        $fileName = $media;
                        // internal 
                        $media_type = pathinfo($uploaded_path, PATHINFO_EXTENSION);
                    } elseif (isset($row['media_type']) && $row['media_type'] == "E") {
                        // external
                        $url = $media;

                        // if mp3 video
                        $filetype = pathinfo($url, PATHINFO_EXTENSION);
                        $video_link = $this->getYoutubeVideoID($url);

                        if (gettype($video_link) !== "boolean") {  // if youtube video
                            $fileName = $video_link;
                        } else {

                            // check if external media is a mp3
                            if ($filetype == "mp3") {
                                $fileName = $url;
                            }
                        }

                        $media_type = "external";
                    }

                    $data = array(
                        'question'  => trim($row['question']),
                        'answer'    => $answer,
                        'clue'      => trim($row['clue']),
                        'level'     => trim($row['level']),
                        'type'      => $question_type,
                        'media'     => $fileName,
                        'media_type' => $media_type,
                    );
                    // DB::table('question_answers')->insert($data);
                    $que_id = DB::table('question_answers')->insertGetId($data);

                    $this->linkQuestionAnswers($que_id, $exeId);
                }
            }
        }

        /*$emptyQuesArr = Arr::where($quesArr, function($value, $key){
			return $value['linked'] == '';
		});*/

        Log::info('out ' . count($quesArr));

        if (count($quesArr) == 0)
            return redirect("questions_answers/import");

        foreach ($quesArr as $row) {
            if (Db::table('question_answers')->where('question', '=', $row['question'])->exists())
                continue;

            // type
            $type = trim($row['type']);
            $question_type = 0;
            // answer
            $answer = trim($row['answer']);
            $answer = str_replace(",", "\,", $answer);

            $fileName = "";
            $media = "";
            $media_type = "";
            $uploaded_path = "";

            $media = trim($row['media']);
            $media_type = trim($row['media_type']);

            // media
            if (isset($row['media_type']) && $row['media_type'] == "I") {
                $uploaded_path = url($media);
                $fileName = $media;
                // internal 
                $media_type = pathinfo($uploaded_path, PATHINFO_EXTENSION);
            } elseif (isset($row['media_type']) && $row['media_type'] == "E") {
                // external
                $url = $media;

                // if mp3 video
                $filetype = pathinfo($url, PATHINFO_EXTENSION);
                $video_link = $this->getYoutubeVideoID($url);

                if (gettype($video_link) !== "boolean") {  // if youtube video
                    $fileName = $video_link;
                } else {

                    // check if external media is a mp3
                    if ($filetype == "mp3") {
                        $fileName = $url;
                    }
                }

                $media_type = "external";
            }

            $data = array(
                'question'  => trim($row['question']),
                'answer'    => $answer,
                'clue'      => trim($row['clue']),
                'level'     => trim($row['level']),
                'type'      => $question_type,
                'media'     => $fileName,
                'media_type' => $media_type,
            );

            // DB::table('question_answers')->insert($data);
            $quest_id = DB::table('question_answers')->insertGetId($data);

            // linked
            $linked_id = trim($row['linked']);

            if ($linked_id > 0) {
                $row = DB::table('question_answers')->where('id', '=', $linked_id)->where('type', '=', 1)->first();
                if ($row === null)
                    continue;

                $this->linkQuestionAnswers($quest_id, $linked_id);
            }
        }

        // print "<pre>";
        // print_r($questionArr);
        Session::flash('success',  'Successfully Imported Questions Answers!');
        return redirect("questions_answers/import");
    }

    // Link Question and Answer
    private function linkQuestionAnswers($question_id = 0, $excercise_id = 0)
    {
        // check if this excercise_id is not in use with any other question.
        $row = DB::table('question_exercise')->where('exercise_question_id', '=', $excercise_id)->first();
        if ($row === null && $excercise_id != 0) {

            $data = array(
                'question_answer_id'     => $question_id,
                'exercise_question_id'   => $excercise_id,
            );

            DB::table('question_exercise')->insert($data);
        }
    }
    /**
     * CSV To ARRAY converter
     */
    private function csvToArray($filename = '', $delimiter = ',')
    {
        // dd($filename);
        if (!file_exists($filename) || !is_readable($filename))
            return false;
        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 10000, $delimiter)) !== false) {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
                // dd($data);

            }
            fclose($handle);
            // dd($header);
        }
        // dd($data);
        // dd($header);
        return $data;
    }

    private function getYoutubeVideoID($url = "")
    {
        // parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
        // return "https://www.youtube.com/embed/". $my_array_of_vars['v'];

        $regex_pattern = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";
        $match;

        if (preg_match($regex_pattern, $url, $match)) {
            return "https://www.youtube.com/embed/" . $match[4];
        } else {
            return false;
        }
    }







    private function checkMp3($url)
    {
        if (!function_exists("curl_init")) die("getHttpResponseCode needs CURL module, please install CURL on your php.");
        $a = parse_url($url);
        if (!isset($a['host'])) {
            return false;
        }
        if (checkdnsrr(str_replace("www.", "", $a['host']), "A") || checkdnsrr(str_replace("www.", "", $a['host']))) {
            $ch = @curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_NOBODY, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $results = explode("\n", trim(curl_exec($ch)));
            $mime = "";
            foreach ($results as $line) {
                if (strtok($line, ':') == 'Content-Type') {
                    $parts = explode(":", $line);
                    $mime = trim($parts[1]);
                }
            }
            // return $mime=="audio/mpeg";
            return true;
        } else {
            return false;
        }
    }
}
