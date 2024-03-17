@extends( 'admin.layouts.app' )
@section( 'content' )
<style>
    .dule-btns {
        display: flex;
    }
    .table .thead-dark th {
        color: #FFF;
        background-color: #3094d1;
        border-bottom: 2px solid #182934;
    }
    .media input , .media select {
        width: 30rem;
    }
    .type input {
        width: 5rem;
    }
    .select2-container .select2-selection--single{
    height:37px !important;
}
.select2-container--default .select2-selection--single{
        border: 2px solid #ced4da !important;
        border-radius: 4px !important;
}
.app-content {
    overflow: hidden;
}
.select2-container .select2-selection--single .select2-selection__rendered {
    border-radius: 4px !important;
}
.clue input {
    width: 8rem !important;
}
.submit_btn {
    text-align: end;
}
.setting_main_btn {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 5rem;
    font-size: 29px;
    width: 90%;
    margin: 0 auto;
    color: #ffffff;
    background-color: #00000054;
    border-color: #000000;
}
.setting_main_btn i {
    font-size: 70px !important;
    animation: colorchange 1.3s infinite alternate;
}
.setting_main_btn strong {
    text-transform: uppercase;
    font-size: 40px;
    font-weight: bold;
    color: #000;
}
.setting_main_btn:hover {
    color: #ffc107;
    background-color: #000000;
    border-color: #000000;
}
.setting_main_btn:hover strong {
    color: #1cc88a;
}
@keyframes colorchange {
      0% {
        
        color: black;
      }
      
      100% {
        
        color: #ffc107;
      }
    }
    /*.underline {
        text-decoration: underline;
        animation: blinging 1.3s infinite alternate;
        transition: .5s;
        margin-bottom: 0;
    }
    @keyframes blinging {
      0% {
        
        text-decoration: none;
      }
      
      100% {
        
        text-decoration: underline;
      }
    }*/
</style>
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css" integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg==" crossorigin="anonymous" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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
            <h3 class="tile-title">Attach Media
             

            </h3>
     
               <?php    $error_mess = explode(',',session('question_import_error')); 
                 if(count($error_mess) >0) {
                  foreach($error_mess as $errmess){
                            if(strlen($errmess) < 3){
                                continue;
                            }
                            ?>   
                                  
                                <div class="alert alert-danger" style="width: 100%"> 
                                            {{ $errmess }}  
                                        </div>

                             <?php
                  }
              }

         ?>


    <script type="text/javascript">
        $(document).ready(function(){
       $("#successMessage").delay(3000).slideUp(300);
});
    </script>

            <div class="main_div">
                          
                           
                        @if(count($media) > 0  )

                 <form class="form-horizontal" method="POST" action="{{ route('store.internal.media.questions') }}" enctype="multipart/form-data">
                     {{ csrf_field() }}


                   
                        

                    <table class="table table-responsive">
                  <thead class="thead-dark">
                    <tr>
                        
                        <th class="text-center">Question /th>
                        <th class="text-center">Select Media</th>
                    </tr>
                  </thead>
                  <tbody>   
              
                         @foreach($all_questions_with_media_type_i as $row)
                            <tr>
                              
                                   <td>
                          <div class="inline_form media">
                              <input type="text" name="question[]" value="{{$row->question}}" readonly=""   class="form-control">
                          </div>
                              <input type="hidden" name="q[]" value="{{$row->id}}"  class="form-control">

                      </td>

                                <td>

                                    
                                  
                             <select  name="media[]" class=" select2 "  required="required">
                               <option value="" >Select Internal Server Media</option> 
                               @foreach($media as $m)
                               <option value="{{$m->id}}">{{$m->file}}        </option>
                              
                               @endforeach 
                            </select>


                               
                                        
                                </td>           

                                </tr>    
                               @endforeach


                    
                                       </tbody>
                </table>
                

                  <div class="tile-footer text-right ">
                    <a href="{{route('questions_answers')}}" class="btn btn-warning"><i class="fa fa-times" aria-hidden="true"></i>           @lang('general.cancel')</a>
                    <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>   @lang('general.save')</button>
                </div>
                </form>

                @else
                <a href="{{route('add.media')}}" class="btn setting_main_btn" ><i class="fa fa-exclamation-circle" aria-hidden="true"></i>  No media added for topic <strong>{{$topic_name}}</strong>,  Click to add media files </a>
                @endif


            </div>
        </div>
    </div>
</div>


<script src="{{url('public/backend/sweetalerts/sweetalert2.all.js')}}"></script>
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
<script>
    $('.select2').select2();
</script>

<script type="text/javascript">
    $(document).ready(function(){
    $('button1').click(function(){
        $('input1').show();
        $('input2').hide();
    });
    $('button2').click(function(){
        $('input2').show();
        $('input1').hide();
    });
});
</script>

@endsection