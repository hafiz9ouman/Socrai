@extends( 'admin.layouts.app' )
@section( 'content' )
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
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
             <li class="breadcrumb-item"><a href="{{url('/questions_answers')}}">All Questions Answers</a>
            </li>
             <li class="breadcrumb-item">Add To Exercise</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-6">
            <div class="tile">
               <!--  @if (session('success'))
                    <div class="alert  alert-info" style="width: 100%">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('Failed'))
                    <div class="alert alert-danger" style="width: 100%">
                        {{ session('Failed') }}
                    </div>
                @endif -->
                <h3 class="tile-title">Add Question To Exercise
                   
                </h3>
        <form class="form-horizontal" method="POST" action="{{ route('store.exercise_question') }}" enctype="multipart/form-data" novalidate>
                    {{ csrf_field() }}
                <div class="table-responsive">
                          

        
                              <div class="form-group ">
                                <label for="comp">Add Question To Following Exercise</label>
                                <select name="exercise_id" class="form-control "  required >
                                    <option value="">---  Select exercise  ---</option>
                                    @foreach ($exercise as $data)
                                        <option value="{{ $data->id }}">{{ $data->question }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" class="form-control" name="question_id" value="{{$id}}">

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
    </div>


   



@endsection
