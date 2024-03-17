@extends( 'admin.layouts.app' )
@section('title', 'Edit Questions Answers')

@section( 'content' )
<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Question and Answers</h1>
        <p>Edit Question and Answers</p>
    </div>
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
                            <input id="question" type="text" class="form-control" value="{{$data->question}}" name="question" required>
                        </div>

                        

                        @php
                        $image_type = array(
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

                        $video_type = array('mp4');
                        $audio_type = array('mp3');
                        @endphp

                        <!-- ahmadcode   show dropdown on check -->
                        @if($data->type == 0)
                        <div class="form-group ">
                            <div class="form-check">
                                <input class="coupon_question form-check-input" type="checkbox" name="check_exercise_question" @if($attach_flag !=null)checked="true" @endif value="1" />
                                <label for="coupon_question"> Add Question to exercise</label>
                            </div>
                        </div>
                        @endif

                        <fieldset class="answerr">
                            <label for="coupon_field">Select Exercise:</label>
                            <select type="text" name="exercise_question" class="form-control" id="coupon_field" />
                            <option value=null> @if($attach_flag != null) {{$attach_flag->question}} @endif</option>
                            @foreach($exercise as $datum)
                            <option value="{{$datum->id}} ">{{$datum->question}}</option>
                            @endforeach

                            </select>
                        </fieldset>
                        <!-- end ahmad cpde -->
                        <div class="form-group">
                            <label class="form-control-label">Answer</label>
                            <textarea class="form-control" rows="3" id="answer" name="answer" placeholder="Please enter answer." required>{{$data->answer}}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Media</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="upload_media" id="media_option1" {{ ( $data->media_type != "external" )? 'checked=checked': '' }}>Upload media
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="media" value="external_media" id="media_option2" {{ ($data->media_type == "external" )? 'checked=checked': '' }}>External media
                                </label>
                            </div>
                        </div>

                        <!-- upload media -->
                        <div class="form-group" id="upload_media">
                            <label class="form-control-label">Upload</label>
                            <input type="file" class="form-control" name="upload" accept="image/*,video/*">
                            <p id="showUploadMessage">Max Upload Size: 10 MB </p>
                        </div>
                        <!-- external media -->
                        <div class="form-group" id="external_media">
                            <label class="form-control-label">Upload</label>

                            @if( $data->media_type == "external")
                            <input type="text" class="form-control" name="external_media" value="{{$data->media}}">
                            @else
                            <input type="text" class="form-control" name="external_media" value="">
                            @endif
                        </div>


                        <div class="form-group" id="upload_media_image">
                            @if( $data->media_type != "external" && in_array($data->media_type, $image_type))
                                <img src="{{ url('public/'.$data->media) }}" width="100" height="100">
                            @elseif( $data->media_type != "external" && in_array( $data->media_type, $video_type) )
                            <video controls poster="{{ url('public/play.png') }}" width="320" height="240">
                                <source src="{{ url('public/'. $data->media) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            @elseif( $data->media_type != "external" && in_array( $data->media_type, $audio_type) )
                            <audio controls>
                                <source src="{{ url('public/'.$data->media) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                            @elseif( $data->media_type == "external")
                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="500" height="300" src="{{ $data->media }}"></iframe>
                            @endif
                        </div>




                        <div class="form-group">
                            <label class="form-control-label">Clue</label>
                            <input id="clue" type="text" class="form-control " value="{{$data->clue}}" name="clue" required>
                        </div>

                        <div class="form-group ">
                            <label for="comp">Topic</label>
                            <select name="topic_id" id="topic_id" class="form-control " required>
                                <option value="">--Select Topic--</option>
                                @foreach ($data->topic as $xc)
                                <option value="{{ $xc->id }}" @if($data->current_topic == $xc->title) selected="true" @endif >{{ $xc->title }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group ">
                            <label for="comp">Level</label>
                            <select name="level" id="topic_id" class="form-control " required>
                                <option value=""> Select Level </option>
                                <option value="1" @if($data->level == 1) selected="true" @endif>1</option>
                                <option value="2" @if($data->level == 2) selected="true" @endif>2</option>
                                <option value="3" @if($data->level == 3) selected="true" @endif>3</option>
                            </select>
                        </div>



                    </div>

                </div>

                <input type="hidden" class="form-control" name="id" value="{{$id}}">

                @if(Auth::check())
                <div class="tile-footer text-right ">
                    <a href="{{route('questions_answers')}}" class="btn btn-default">@lang('general.cancel')</a>
                    <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                </div>
                @endif
            </form>

        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        @if($attach_flag != null)
        $(".answerr").show();
        @else
        $(".answerr").hide();

        @endif


        $(".coupon_question").click(function() {
            if ($(this).is(":checked")) {
                $(".answerr").show();
            } else {
                $(".answerr").hide();
            }
        });

    });


    $('.form-check-label').click(function() {
        $("#upload").attr("required", "true");
        $('#answer').removeAttr('required');
    });

    // media radio 
    @if($data->media_type == "external")

    $("#external_media").show();
    $("#upload_media").hide();
    $("#upload_media_image").hide();

    @else

    $("#external_media").hide();
    $("#upload_media").show();
    $("#upload_media_image").show();

    @endif


    // upload media
    $('#media_option1').click(function() {

        $("#upload_media").show();
        $("#external_media").hide();
        $("#upload_media_image").show();
    });
    // external media
    $('#media_option2').click(function() {

        $("#upload_media").hide();
        $("#external_media").show();
        $("#upload_media_image").hide();
    });
</script>

@endsection