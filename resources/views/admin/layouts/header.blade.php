<header class="app-header">

  <a style="font-family: none;" class="app-header__logo  " href="https://dev.socrai.com/admin">
        <img src="{{asset('images/logo.png')}}" class="img-fluid">
   </a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
     <?php $check_2fa = DB::table('login_securities')->where('user_id' , auth()->user()->id)->pluck('google2fa_enable')->first();

      ?>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
    			{{-- <li><a class="dropdown-item" href="{{url('/profile-view')}}"><i class="fa fa-sign-out fa-lg"></i> Profile </a></li> --}}
          {{-- check if two factor is enabled --}}
          <!-- @if( $check_2fa == null || $check_2fa == 0  )
    			 <li><a class="dropdown-item" href="{{url('/2fa')}}"><i class="fa fa-sign-out fa-lg"></i>Enable 2fa</a></li>
          @endif
          @if($check_2fa == 1)
           <li><a class="dropdown-item" href="{{url('/2fa/disable')}}"><i class="fa fa-sign-out fa-lg"></i>Disable 2fa</a></li>
           @endif -->
           @if(Auth::user()->tfa == 1)
              <li><a class="dropdown-item" href="{{url('/2mfa/disable')}}"><i class="fa fa-sign-out fa-lg"></i>Disable 2fa</a></li>
           @else
              <li><a class="dropdown-item" href="{{url('/2mfa')}}"><i class="fa fa-sign-out fa-lg"></i>Enable 2fa</a></li>
           @endif
          
            <li><a class="dropdown-item" href="{{url('/update-password/'.auth()->user()->id)}}"><i class="fa fa-sign-out fa-lg"></i>Change Password</a></li>

          <li><a class="dropdown-item" href="{{url('logout')}}"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
