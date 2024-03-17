<?php

namespace App\Http\Controllers\sucrai\admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;

class TopicController extends Controller
{

    public function index(){
        $topic = DB::table('topics')->orderBy('title')->get();
        foreach ($topic as $tc){
            $tribe = DB::table('tribes')->where('id' , '=' , $tc->tribe_id)->pluck('title')->first();
            $tc->tribe = $tribe;
        }
        return view('admin.topics.home' , compact('topic'));
    }
    public function add(){
        $tribe = DB::table('tribes')->get();
//        dd($topcs);
        return view('admin.topics.add', compact('tribe'));
    }
    public function store(Request $request){
//        dd($request);
       $result=   DB::table('topics')->insert([
           'title' => $request->title,
           'tribe_id' => $request->tribe_id,
           'created_at'=> carbon::now(),
           
           'question_points'=> $request->question_points,
           'exercise_points'=> $request->exercise_points,
           'exercise_points_correct'=> $request->exercise_points_correct,
       ]);
//       dd($result);
        Session::flash('success', 'Successfully Added topic ');
        return redirect('topics');
//    return redirect() -> route('add.topic');
    }
    public function destroy(Request $request){
        $id = $request->input("id");
        DB::table('question_answers')->where('topic_id' , $id)->delete();
        DB::table('user_questions')->where('topic_id' , $id)->delete();
       DB::table('topics')->where('id' ,$id )->delete();
    }

    public function edit($id){
        $topic = DB::table('topics')->where('id',$id)->first();
        $tribe = DB::table('tribes')->get();
        $id = $id;

        return view('admin.topics.edit',compact('topic','tribe','id'));
    }

    public function update(Request $request){
        DB::table('topics')->where('id',$request['id'])->update([
             'title'=>$request['title'],
             'question_points'=> $request->question_points,
             'exercise_points'=> $request->exercise_points,
             'exercise_points_correct'=> $request->exercise_points_correct,
          
       ]);
//       dd($result);
        Session::flash('success', 'Successfully Updated topic ');
        return redirect('topics');
    }
}
