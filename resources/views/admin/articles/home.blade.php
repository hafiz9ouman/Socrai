@extends( 'admin.layouts.app' )
@section( 'content' )
    <style>
        .dule-btns{
            display: flex;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>

    <div class="app-title">

        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i>
            </li>
            <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">All Articles</li>
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
            
                <div class="table-responsive">
                    <table id = "example" class="table">
                        <thead class="back_blue">
                        <tr>
                            <th style="display: none;">#Sr</th>
                            <th>Title </th>
                             
                               <th>Topic </th>
                             <th>Tribe </th>
                             <th>Date </th>
                           
                            <th>Total Comments</th>

                            <th width="130" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $counter = 1;?>
                        @foreach($data as $row)
                            <tr >
                                <td style="display: none;"><?php echo $counter;?></td>
                                <?php $counter++;?>
                                 <td>
                                    {{$row->article_title}}
                                </td>

 <td>
                                    {{$row->topicTitle}}
</td>
                                     <td>
                                    {{$row->tribeTitle}}
                                </td>

                                
                                
                                    <td>
                                    {{$row->created_at}}
                                </td>

                                <td>
                                    

                                    <?php
$count = DB::table('discussions')->where('discussions.article_id' , $row->id)->join('users' , 'users.id' , '=' , 'discussions.user_id')->count();
         echo $count;                      
         $comments_link = '/article_comments/'.$row->id; ?></td>

                                <td>
                                    <a class=" btn btn-sm btn-dark" href='{{$comments_link}}'  style="color:white;"><i class="fa fa-eye mr-1"  aria-hidden="true"></i> Manage Comments </a>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    

    <script>

        $(document).ready(function() {
            $('#example').DataTable( {
                "order": [[ 0, "asc" ]]
            } );
        } );

    </script>



@endsection
