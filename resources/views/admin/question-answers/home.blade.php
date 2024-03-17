@extends( 'admin.layouts.app' )
@section( 'content' )
<style>
    .dule-btns {
        display: flex;
    }
</style>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />



<div class="app-title">

    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
        </li>
        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Question & Answers</li>
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
       <?php    $error_mess = explode(';',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   
                                  
                                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                          <strong>  {!! $errmess !!}  </strong>
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                <!-- <div class="alert alert-danger" style="width: 100%"> 
                                          
                                        </div> -->

                             <?php
                  }
              }

         ?>
           

            <h3 class="tile-title">Questions Answers
                @if(Auth::check() )
                <a href="{{route('add.question')}}" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Add Question</a>
                @endif

                &nbsp;&nbsp;&nbsp;<a href="{{url('/questions_answers/import')}}" class="btn btn-sm btn-success pull-right cust_color"><i class="fa fa-plus"></i> Import</a>

            </h3>
            <div class="table-responsive">
                <table id="example" class="table">
                    <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Question</th>
                            <th>Media</th>
                            <th>Answer</th>
                            <th>Clue</th>
                            <th>Exercise</th>
                            <th>Topic</th>
                            <th>level</th>
                            <th>Attach to Exercise</th>
                            <th width="130" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $counter = 1;

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
                        ?>


                        @foreach($questions as $row)
                        <tr @if($row->type == 1) style="background : #D1D1D2 ;" @endif>
                            <td style="display: none;"><?php echo $counter; ?></td>
                            <?php $counter++; ?>
                            <td>{{$row->question}}</td>
                            <td style="text-transform: none;">

                             

                                @if($row->media_type == "external" )
                                
                                    
                                    @php
                                        $filetype = pathinfo($row->media, PATHINFO_EXTENSION);
                                    @endphp
                                    @if( $filetype == "mp3" )
                                        
                                        <img src="{{ url('public/audio-placeholder.png') }}" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a{{$counter}}" href="javascript:;" />
                                        <div style="display: none;" id="hidden-content-a{{$counter}}">
                                            <audio controls  autostart="0" autostart="false" preload ="none">
                                                <source src="{{ $row->media }}" type="audio/mpeg">
                                                Your browser does not support the audio element.
                                            </audio>
                                        </div>

                                    @else
                                        <img src="{{ 'public/play.png'}}" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a{{$counter}}" href="javascript:;" />
                                        <div style="display: none;" id="hidden-content-a{{$counter}}">
                                            <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" width="500" height="300" src="{{ $row->media }}"></iframe>
                                        </div>
                                    @endif




                                @else

                                @if(file_exists(public_path($row->media)))
                                @if( in_array( $row->media_type, $image_type) )
                                {{-- image  --}}
                                <!-- <img data-fancybox="images" src="{{ 'public'. $row->answer }}" style="width:50px" id="inline" href="#data{{ $counter }}"> -->

                                <a href="{{ 'public'. $row->media }}" data-fancybox="images" data-caption="">
                                    <img src="{{ 'public'. $row->media }}" style="width:50px" />
                                </a>

                                @elseif( in_array( $row->media_type, $video_type) )
                                {{-- video  --}}
                                <img src="{{ 'public/play.png'}}" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a{{$counter}}" href="javascript:;" />
                                <div style="display: none;" id="hidden-content-a{{$counter}}">
                                    <video controls="controles" data-autoplayvideo="false"  data-playvideoonclick="false" poster="{{ 'public/play.png'}}" id="video_ifram" width="320" height="240">
                                        <source src="{{ 'public'. $row->media }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>

                                </div>
                                @elseif( in_array( $row->media_type, $audio_type) )
                                {{-- audio --}}
                                    <img src="{{ url('public/audio-placeholder.png') }}" style="width:50px;cursor: pointer;" data-fancybox data-src="#hidden-content-a{{$counter}}" href="javascript:;" />
                                    <div style="display: none;" id="hidden-content-a{{$counter}}">
                                        <audio controls  autostart="0" autostart="false" preload ="none">
                                            <source src="{{ url( '/public'.$row->media) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>

                                @endif
                                @endif
                                @endif
         
                            </td>
                            <td>
                               {{$row->answer}}
                                
                            </td>


                            <td>{{$row->clue}}</td>
                            <td>
                                @if( $row->type == 1)
                                Exercise
                                @else
                                Question
                                @endif

                            </td>
                            <td>{{$row->topic}}</td>
                            <td>{{$row->level}}</td>
                            <td>
                                @if($row->type == 0)


                                @if($row->linked == null && $row->type != 1)

                                <table class="table-bordered table">
                                    <tbody>
                                        <tr>
                                            <td> <a href="{{url('/questions_answers/addToExercise/' . $row->id)}}" class="btn btn-sm btn-warning text-center" style="float: left;"><i class="fa fa-paperclip" aria-hidden="true"></i> Attach To Exercise </a> </td>
                                        </tr>
                                        <tr>
                                            <td> <a href="{{url('/questions_answers/makeItExercise/' . $row->id)}}" class="btn btn-sm btn-dark text-center" style="float: left;"><i class="fa fa-check-circle" aria-hidden="true"></i> Make It Exercise </a></td>
                                        </tr>
                                    </tbody>
                                </table>

                                @elseif($row->linked != null && $row->type != 1)
                                <table class="table-bordered table">
                                    <tbody>
                                        <tr>
                                            <th> <strong>Attached to :</strong> </th>
                                        </tr>
                                        <tr>
                                            <td>{{$row->linked}}</td>
                                        </tr>
                                        <td colspan="2">
                                            <a href="{{url('/questions_answers/makeItExercise/' . $row->id)}}" class="btn btn-sm btn-dark text-center" style="float: left;"><i class="fa fa-star"></i> Make it exercise </a>
                                        </td>
                                    </tbody>
                                </table>
                                @endif
                                @else
                                <a href="{{url('/questions_answers/removefromExercise/' . $row->id)}}" class="btn btn-sm btn-danger text-center" style="float: left;"><i class="fa fa-times-circle" aria-hidden="true"></i> Remove From Execise </a>
                                @endif




                            </td>

                            <td class="text-center">
                                <div class="actions-btns dule-btns float-lg-right">

                                    <a href="{{url('/questions_answers/edit/' . $row->id)}}" class="btn btn-sm btn-info" style="float: left;"><i class="fa fa-edit"></i></a>
                                    <a href="javascript:void(0)" data-id="{{$row->id}}" class="btn btn-sm btn-danger delete "><i class="fa fa-trash"></i></a>


                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script src="{{url('public/backend/sweetalerts/sweetalert2.all.js')}}"></script>
<script type="text/javascript">
	// $('#video_ifram').get(0).stopVideo();

</script>
<script type="text/javascript">
    $('[data-fancybox]').fancybox({
        protect: true
    });


    $("body").on("click", ".delete", function() {
        var task_id = $(this).attr("data-id");
        var form_data = {
            id: task_id
        };
        swal({
            title: "Do you want to delete this Question",
            //text: "@lang('category.delete_category_msg')",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#F79426',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            showLoaderOnConfirm: true
        }).then((result) => {
            if (result.value == true) {
                $.ajax({
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '<?php echo url("/questions_answers/delete"); ?>',
                    data: form_data,
                    success: function(msg) {
                        swal("@lang('Question Deleted Successfully')", '', 'success')
                        setTimeout(function() {
                            location.reload();
                        }, 900);
                    }
                });
            }
        });
    });
</script>
<style>
    .sweet-alert h2 {
        font-size: 1.3rem !important;
    }

    .sweet-alert .sa-icon {
        margin: 30px auto 35px !important;
    }
</style>


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
    });
</script>


@endsection