@extends( 'admin.layouts.app' )

@section( 'content' )
    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/site_admin')}}">Site Admins</a>
            </li>
            <li class="breadcrumb-item">Add Admin</li>
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
                <h3 class="tile-title">Add Admin</h3>
                <form class="form-horizontal" method="POST" action="{{ url('site_admin/store') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="title">Image</label>
                                <input  id="image"  type="file" placeholder="image" class="form-control" name="image">
                            </div>
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Name</label>
                                <input id="name" type="text" class="form-control " name="name" required >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Email</label>
                                <input id="email"  type="email" class="form-control " autocomplete="off" value="" name="email"  required >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input id="password"  type="password" class="form-control " value=""  autocomplete="off" name="password"  required >
                            </div>
                        </div>


                        <!-- 
                            <div class="col-sm-6 col-md-4">
                                <div class="form-group">
                                    <label class="form-control-label">Phone</label>
                                    <input id="phone" type="text" class="form-control" name="phone"  >
                                </div>
                            </div> 
                        -->


                       <!--  <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">State</label>
                                <input id="state" pattern="[a-zA-Z]+"type="text" class="form-control" required="" name="state" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">City</label> 
                                <input id="city" type="text" pattern="[a-zA-Z]+" class="form-control" required="" name="city" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <div class="form-group">
                                <label class="form-control-label">Country</label>
                                <input id="country" type="text" pattern="[a-zA-Z]+" class="form-control" required="" name="country" required  >
                            </div>
                        </div> -->


                    </div>
                    @if(Auth::check())
                        <div class="tile-footer text-right " >
                            <a href="{{url('site_admin')}}" class="btn btn-default">@lang('general.cancel')</a>
                            <button type="submit" class="btn btn-primary">@lang('general.save')</button>
                        </div>
                    @endif
                </form>

            </div>

        </div>
    </div>


@endsection


