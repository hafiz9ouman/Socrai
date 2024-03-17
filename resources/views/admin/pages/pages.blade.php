@extends( 'admin.layouts.app' )

@section( 'content' )
    <div class="app-title">
      
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            {{-- <li class="breadcrumb-item"><a href="{{route('tribes')}}">All Tribes</a> --}}
            </li>
            <li class="breadcrumb-item">Edit Pages</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

        <div class="tile container">
                <h3 class="tile-title">Pages</h3>
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
                <form class="form-horizontal" method="POST" action="{{ url('/pages/update') }}" enctype="multipart/form-data">

                    {{-- <div class="row"> --}}


                    {{ csrf_field() }}
                        {{-- <div class=""> --}}
                                <h1 class="form-control-label">Terms of use</h1>
                                
                                <textarea   class="form-control " name="terms_of_user" style="width: 100%;" required placeholder="Enter description." maxlength="150"   id="txtEditor2" >
                                        @if(isset($data) )
                                              {!! $data->terms_of_user !!}
                                        @endif
                               </textarea>
                         
                                <hr>

                                <h1 class="form-control-label">Privace Policy - GDPR</h1>
                               
 
                                  <textarea   class="form-control " name="privace_policy"  style="width: 100%;" required placeholder="Enter description." maxlength="150"   id="txtEditor" >
                                      @if(isset($data) )
                                        {!! $data->privacy_policy !!}
                                      @endif  

                        </textarea>
                         @if(isset($data))
                            <input type="hidden"  name="page_id"  value="{{ $data->id }}">
                         @endif
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{url('pages')}}" class="btn btn-default">@lang('general.cancel')</a>
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

        CKEDITOR.replace('txtEditor2', { 
          
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