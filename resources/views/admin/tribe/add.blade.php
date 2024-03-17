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
            <li class="breadcrumb-item"><a href="{{route('tribes')}}">All Tribes</a>
            </li>
            <li class="breadcrumb-item">Add Tribe</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <h3 class="tile-title">Add Tribe</h3>
                <form class="form-horizontal" method="POST" action="/tribe_stores" enctype="multipart/form-data">

                    <div class="row">


                    {{ csrf_field() }}
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Title</label>
                                <input id="title" type="text" class="form-control " name="title" required placeholder="Enter title.">
                            </div>
                       
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <!-- <textarea class="form-control " name="description" required placeholder="Enter description." id="description"></textarea> -->
 
                                  <textarea   class="form-control " name="description" required placeholder="Enter description." maxlength="150"   id="txtEditor" >

                        </textarea>
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

    <script src="//cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
  
    <script>
        $(document).ready(function() {
            // CKEDITOR.replace( 'txtEditor' );



        CKEDITOR.replace('txtEditor', { 
          
            maxLength: 10, 
            toolbar: 'TinyBare', 
            toolbar_TinyBare: [
                 ['Bold','Italic','Underline'],
                 ['Undo','Redo'],['Cut','Copy','Paste'],
                 ['NumberedList','BulletedList','Table'],
            ] 
        });



        });



           

    </script>

@endsection