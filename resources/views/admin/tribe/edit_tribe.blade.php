@extends( 'admin.layouts.app' )

@section( 'content' )
<style>
    .cke_notifications_area{
        display: none;
    }
</style>
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
            <li class="breadcrumb-item">Edit Tribe</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="tile">
                <h3 class="tile-title">Edit Tribe</h3>
                <form class="form-horizontal" method="POST" action="{{ url('/tribe/update_data') }}" enctype="multipart/form-data">

                    <div class="row">


                    {{ csrf_field() }}
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Title</label>
                                <input id="title" type="text" class="form-control" value="{{ $data->title }}" name="title" required placeholder="Enter title.">
                            </div>
                       
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <!-- <textarea class="form-control " name="description" required placeholder="Enter description." id="description"></textarea> -->
 
                                  <textarea   class="form-control"  name="description" required placeholder="Enter description." maxlength="150"   id="txtEditor" >

                                   {!! $data->description !!}

                               </textarea>
                               <input type="hidden" name="tribe_id"  value="{{ $id }}">
                            </div>
                        </div>                       

                    </div>
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{route('tribes')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary">@lang('general.save')</button>
				<a href="javascript:;" class="btn btn-danger delete ">Delete</a>

                        </div>
                    @endif
                </form>

            </div>

        </div>
    </div>

    <script src="//cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
  
    <script>

        // CKEDITOR.instances["my-content"].setData("<p>Hello World</p>");
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
            // var des = document.getElementById('fetch_desc');
       // CKEDITOR.instances["txtEditor"].setData(v);



        });



           

    </script>



<script type="text/javascript">
        $( "body" ).on( "click", ".delete", function () {
            var tribe_id = {{$id}};

            var form_data = {
                id: tribe_id
            };
            swal({
                title: "Deleting this tribe will delete everything for this tribe ( Users,topics,articles etc)",
                //text: "@lang('category.delete_category_msg')",
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#F79426',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                showLoaderOnConfirm: true
            }).then( ( result ) => {
                if ( result.value == true ) {
                    $.ajax( {
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $( 'meta[name="csrf-token"]' ).attr( 'content' )
                        },
                        url: '<?php echo url("tribes/delete"); ?>',
                        data: form_data,
                        success: function ( msg ) {
                            swal( "@lang('Tribe Deleted Successfully')", '', 'success' )
                            setTimeout( function () {
                                window.location.href = "{{ url('tribes') }}";
                            }, 900 );
                        }
                    } );
                }
            } );
        } );
    </script>


@endsection