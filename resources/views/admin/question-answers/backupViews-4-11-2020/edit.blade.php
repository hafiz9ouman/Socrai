@extends( 'admin.layouts.app' )

@section( 'content' )
    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
             <li class="breadcrumb-item"><a href="{{url('/questions_answers')}}">All Questions Answers</a>
            </li>
             <li class="breadcrumb-item">Edit Questions Answers</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                @if (session('success'))
                    <div class="alert  alert-info" style="width: 100%">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('Failed'))
                    <div class="alert alert-danger" style="width: 100%">
                        {{ session('Failed') }}
                    </div>
                @endif
                <h3 class="tile-title">Edit Questions & Answer</h3>
                <form class="form-horizontal" method="POST" action="{{ route('update.question') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-control-label">Question</label>
                                <input id="question" type="text" class="form-control" value="{{$data->question}}" name="question" required >
                            </div>
                        

                        
                            <div class="form-group">
                                <label class="form-control-label">Points</label>
                                <input id="points" type="text" class="form-control" value="{{$data->points}}" name="points" required >
                            </div>
                        
	
									<?php 
									$image_type  = array('image/png',
														 'image/jpeg',
														 'image/pjpeg',
														 'image/gif'                                             
													 ); 

									$video_type  = array('video/mp4');
									
									 $flag = false 
									?>
						
									@if (strpos($data->answer, '/media/questions_answers') !== false)
                                        @if(file_exists(public_path($data->answer)))                                            

                                            @php
                                                $media_type = mime_content_type(public_path($data->answer));
                                            @endphp

                                            @if( in_array( $media_type, $image_type) )
                                                <div class="form-group ">
                                                    <img src="{{ 'public'. $data->answer }}" alt="" style="width:50px" />
												</div>
                                            @else 
												<div class="form-group ">
                                                <video controls poster="{{  url('public'.'/play.png') }}" width="320" height="240">
                                                  <source src="{{  url('public'.$data->answer) }}" type="video/mp4">
                                                  Your browser does not support the video tag.
                                                </video>
												</div>
                                            @endif 
                                           
										   
										   @php
										      $flag = true;
										   @endphp
                                        @endif
									@else 
                                   
                                    @endif
							<div class="form-group ">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="upload_media form-check-input" type="checkbox" name="upload_media" value="1" onchange="valueChanged()" {{ ($flag==true )? 'checked=checked': '' }} /> Upload Media as Answer
                                    </label>
                                </div>
                            </div>
							

                            <!-- ahmadcode   show dropdown on check -->
                                
                              @if($data->type == 0)
                                <div class="form-group ">
                                 <div class="form-check">
                                    <input class="coupon_question form-check-input" type="checkbox" name="check_exercise_question" @if($attach_flag != null)checked="true" @endif value="1" />
                                     <label for="coupon_question"> Add Question to exercise</label>
                                  </div>
                                 </div>
                                 @endif

                            


				            

                             <fieldset class="answerr">
                               <label for="coupon_field">Select Exercise:</label>
                               <select type="text" name="exercise_question" class="form-control" id="coupon_field"/>
                                   <option value=null> @if($attach_flag != null) {{$attach_flag->question}} @endif</option>
                                 @foreach($exercise as $datum)
                                  <option value="{{$datum->id}} ">{{$datum->question}}</option>
                                  @endforeach

                               </select>
                             </fieldset>
                             <!-- end ahmad cpde -->
							<div class="form-group">
                                <label class="form-control-label">Answer</label>
								
								@if($flag==true )
									<textarea class="form-control" rows="3" id="answer" required name="answer" placeholder="Please enter answer."></textarea>
								@else
								 <textarea class="form-control" rows="3" id="answer" required name="answer" placeholder="Please enter answer.">{{$data->answer}}</textarea>
								@endif
							
                                <input type="file" class="form-control " id="upload" name="upload"   accept="image/*,video/*">
                                <p id="showUploadMessage">Max Upload Size: 10 MB </p>
                            </div>
							
							
							
							
                        
                            <div class="form-group">
                                <label class="form-control-label">Clue</label>
                                <input id="clue"  type="text" class="form-control "  value="{{$data->clue}}" name="clue"  required >
                            </div>
                       


                        <div class="form-group ">
                            <label for="comp">Topic</label>
                            <select name="topic_id" id="topic_id" class="form-control "  required >
                                <option value="">--Select Topic--</option>
                                @foreach ($data->topic as $xc)
                                    <option value="{{ $xc->id }}"  @if($data->current_topic == $xc->title)  selected="true" @endif >{{ $xc->title }}</option>
                                @endforeach
                            </select>
						</div>
                         
						 
						<div class="form-group ">
                            <label for="comp">Level</label>
                            <select name="level" id="topic_id" class="form-control "  required >
                                <option value=""> Select Level </option>
                                <option value="1"  @if($data->level == 1)  selected="true" @endif>1</option>
                                <option value="2" @if($data->level == 2)  selected="true" @endif>2</option>
                                <option value="3" @if($data->level == 3)  selected="true" @endif>3</option>
                            </select>
						</div>
						
						
						
						</div>
						
                    </div>

                    <input type="hidden" class="form-control" name="id" value="{{$id}}">

                @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{route('questions_answers')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                        </div>
                    @endif
                </form>

            </div>

        </div>
    </div>

<script type="text/javascript">
    
// $(".coupon_question").click(function() {
//     if($(this).is(":checked")) {
//         $(".answerr").show();
//     } else {
//         $(".answerr").hide();
//     }
// });


$(document).ready(function(){
    

    @if($attach_flag != null)
      $(".answerr").show();
    @else
  $(".answerr").hide();

    @endif


    $(".coupon_question").click(function() {
        if($(this).is(":checked")) {
            $(".answerr").show();
        } else {
            $(".answerr").hide();
        }
    });

});




	@if($flag==true )
		$("#answer").hide();
	$("#upload").show();
	@else
		 $("#answer").show();
		 $("#upload").hide();

		$("#showUploadMessage").hide();
	@endif
								
								
    function valueChanged()
    {
        if($('.upload_media').is(":checked"))
        {
            $("#answer").hide();

            $("#upload").show();

            $("#showUploadMessage").show();
        }
        else
        {
            $("#answer").show();
            
            $("#upload").hide();
            $("#showUploadMessage").hide();
        }
    }


    $('.form-check-label').click(function(){
        $("#upload").attr("required", "true");
        $('#answer').removeAttr('required');
    });


</script>

@endsection