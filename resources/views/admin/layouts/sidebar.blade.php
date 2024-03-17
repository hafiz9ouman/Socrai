<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  
  @if(Auth::user()->image!="")

  <a href="/update-profile/{{auth()->user()->id}}"><div class="app-sidebar__user"><img class="app-sidebar__user-avatar" style="width: 83px; height: 83px;" src="{{env('APP_URL')}}/images/sucrai/{{Auth::user()->image }}" alt="User Image">
    <div>
    </a>
      @else
     
      <div class="app-sidebar__user">

        <img class="app-sidebar__user-avatar" src="{{env('APP_URL')}}/images/sucrai/abc.png" alt="User Image" style="width: 83px; height: 83px;">
        


        <div>
          @endif
          <p class="app-sidebar__user-name">@if((Auth::user()->user_role) == '2') {{'Socrai Leader'}} @endif</p>
          <p class="app-sidebar__user-name">@if((Auth::user()->user_role) == '1') {{'Socrai Admin'}} @endif</p>
          <p class="app-sidebar__user-name">{{Auth::user()->name}}</p>
          <p class="app-sidebar__user-designation">{{Auth::user()->email}}</p>
        </div>
      </div>
      <ul class="app-menu">

        @if((Auth::user()->user_role) != 3)


        @if((Auth::user()->user_role) == '1')
            <li><a class="app-menu__item <?php if (Request::segment(1) == "site_admin") echo "active"; ?>" href="{{url('site_admin')}}"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label"> Manage Site Admins</span></a></li>


        @endif   


        <li><a class="app-menu__item <?php if (Request::segment(1) == "join_requests") echo "active"; ?>" href="{{url('join_requests')}}"> <i class="fa fa-bell" aria-hidden="true"></i> <span class="app-menu__label"> See Join Requests</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "users") echo "active"; ?>" href="{{url('users')}}"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label">  Manage Users</span></a></li>
    

        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribes") echo "active"; ?>" href="{{url('tribes')}}"><i class="fa fa-wrench" aria-hidden="true"> </i>
<span class="app-menu__label"> Manage Tribes</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribeleader") echo "active"; ?>" href="{{url('tribeleader')}}"><i class="fa fa-user-circle-o" aria-hidden="true"> </i>
<span class="app-menu__label"> Tribe Leaders</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "socraileader") echo "active"; ?>" href="{{url('socraileader')}}"><i class="fa fa-check-circle" aria-hidden="true"> </i>
<span class="app-menu__label"> Socrai Leaders</span></a></li>

        <li><a class="app-menu__item <?php if (Request::segment(1) == "questions_answers") echo "active"; ?>" href="{{url('questions_answers')}}"><i class="fa fa-pencil-square-o" aria-hidden="true"> </i><span class="app-menu__label">Questions Answers</span></a></li>
        
        <li><a class="app-menu__item <?php if (Request::segment(1) == "topics") echo "active"; ?>" href="{{url('topics')}}"><i class="fa fa-grav" aria-hidden="true">  </i><span class="app-menu__label"> Topics</span></a></li>
        <li><a class="app-menu__item <?php if (Request::segment(1) == "/media/home") echo "active"; ?>" href="{{url('/media/home')}}"><i class="fa fa-file-image-o" aria-hidden="true"> </i><span class="app-menu__label"> Add Media</span></a></li>
        @endif

          @if((Auth::user()->user_role) == '1')
            <li><a class="app-menu__item <?php if (Request::segment(1) == "pages") echo "active"; ?>" href="{{url('pages')}}"> <i class="app-menu__icon fa fa-users"></i> <span class="app-menu__label"> Manage Pages</span></a></li>
          @endif 

        @if((Auth::user()->user_role) == 3)
        <li><a class="app-menu__item <?php if (Request::segment(1) == "tribesleader") echo "active"; ?>" href="{{url('tribesleader')}}"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Tribe members</span></a></li>
        @endif
        
        <li><a href="{{url('discussions')}}" class="app-menu__item" href="javascript:;"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Discussions</span></a></li>


        <li><a class="app-menu__item" href="{{url('logout')}}"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Logout</span></a></li>

      </ul>
    </div>
  </div>
</aside>