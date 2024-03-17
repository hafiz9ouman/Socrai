@extends( 'admin.layouts.app' )
@section( 'content' )
<div class="app-title">
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
        </li>
        <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item"><a href="{{url('/questions_answers')}}">All Questions Answers</a>
        </li>
        <li class="breadcrumb-item">Add Questions Answers</li>
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
            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <h3 class="tile-title">Add Questions & Answer</h3>
            <form class="form-horizontal" method="POST" action="{{ route('store.question') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="form-control-label">Question</label>
                            <input id="question" type="text" class="form-control " name="question" required placeholder="Please enter question.">
                        </div>
                        <div class="form-group ">
                            <label class="form-control-label">Points</label>
                            <input class="form-control" type="text" name="points" placeholder="Please enter points." />
                        </div>
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="questiontype" value="1" /> Exercise Question
                                </label>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="upload_media form-check-input" type="checkbox" name="upload_media" value="1" onchange="valueChanged()" /> Upload Media as Answer
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Answer</label>
                            <textarea class="form-control" rows="3" id="answer" name="answer" required placeholder="Please enter answer."></textarea>
                            <input type="file" class="form-control " id="upload" name="upload" required accept="image/*,video/*">
                            <p id="showUploadMessage">Max Upload Size: 10 MB </p>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Clue</label>
                            <input id="clue" type="text" class="form-control " name="clue" required placeholder="Please enter clue.">
                        </div>
                        <div class="form-group">
                            <label for="comp">Topic</label>
                            <select name="topic_id" id="topic_id" class="form-control " required>
                                <option value="">--- Select Topic ---</option>
                                @foreach ($topics as $data)
                                <option value="{{ $data->id }}">{{ $data->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="comp">Level</label>
                            <select name="level" id="topic_id" class="form-control " required>
                                <option value="">--- Select Level ---</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                </div>
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
    $('form').submit(function(event) {
        if ($(this).hasClass('submitted')) {
            event.preventDefault();
        } else {
            $(this).find(':submit').html('<i class="fa fa-spinner fa-spin"></i>');
            $(this).addClass('submitted');
        }
    });
    $("#upload").hide();

    function valueChanged() {
        if ($('.upload_media').is(":checked")) {
            $("#answer").hide();
            $("#upload").show();
            $("#showUploadMessage").show();
        } else {
            $("#answer").show();
            $("#upload").hide();
            $("#showUploadMessage").hide();
        }
    }
    $('.form-check-label').click(function() {
        $("#upload").attr("required", "true");
        $('#answer').removeAttr('required');
    });
</script>
@endsection