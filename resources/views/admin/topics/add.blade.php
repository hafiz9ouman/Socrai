@extends( 'admin.layouts.app' )

@section( 'content' )
    <div class="app-title">
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
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{route('topics')}}">All topics</a>
            </li>
            <li class="breadcrumb-item">Add Topic</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <h3 class="tile-title">Add Topic</h3>
                <form class="form-horizontal" method="POST" action="{{ route('store.topic') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Title</label>
                                <input id="title" type="text" class="form-control " name="title" required >
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Point for Question</label>
                                <input id="question_points" type="number" class="form-control " name="question_points" required>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Point for Exercise</label>
                                <input id="exercise_points" type="number" class="form-control " name="exercise_points" required>
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Correct Exercise Point</label>
                                <input id="exercise_points_correct" type="number" class="form-control " name="exercise_points_correct" required>
                            </div>
                        </div>



                    </div>
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{route('topics')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                        </div>
                    @endif
                </form>

            </div>

        </div>
    </div>


@endsection


