@extends( 'layouts.2factorlayout' )

@section('content')





    <section class="dashboard">
    <div class="row m-0">
  
        <div class="col-md-12 p-0">
          <div class="detail_section" data-aos="zoom-in" data-aos-duration="1000">
            

             <div class="settings">
    <div class="container">

        <div class="row justify-content-md-center">

            <div class="col-md-12">

                <div class="fa_title">

                    <h2>Two Factor Authentication</h2>


                    <div class="fa_detail">

                      <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>




                        @if (session('error'))

                            <div class="alert alert-danger">

                                {{ session('error') }}

                            </div>

                        @endif

                        @if (session('success'))

                            <div class="alert alert-success">

                                {{ session('success') }}

                            </div>

                        @endif



                        @if($data['user']->loginSecurity == null)

                            <form class="form-horizontal" method="POST" action="{{ route('generate2faSecret') }}">

                                {{ csrf_field() }}

                                <div class="fa_btn">

                                    <button type="submit" class="btn btn-block btn-dark">

                                        Generate Secret Key to Enable 2FA

                                    </button>

                                </div>

                            </form>

                        @elseif(!$data['user']->loginSecurity->google2fa_enable)

                            <p class="fa_scan_code">1. Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: <code>{{ $data['secret'] }}</code></p>
                            <br/>

                            <img src="{{$data['google2fa_url'] }}" alt="">

                            <br/><br/>

                            <p>2. Enter the pin from Google Authenticator app</p>

                            <form class="form-horizontal" method="POST" action="{{ route('enable2fa') }}">

                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('verify-code') ? ' has-error' : '' }}">

                                    <label for="secret" class="control-label">.Authenticator Code</label>

                                    <input id="secret" type="password" class="form-control col-md-4" name="secret" required>

                                    @if ($errors->has('verify-code'))

                                        <span class="help-block">

                                        <strong>{{ $errors->first('verify-code') }}</strong>

                                        </span>

                                    @endif

                                </div>

                                <button type="submit" class="btn btn-success enable_btn">

                                   Enable 2FA

                                </button>

                            </form>

                        @elseif($data['user']->loginSecurity->google2fa_enable)

                            <!-- <div class="alert alert-success">

                                2FA is currently <strong>enabled</strong> on your account.

                            </div>

                            <p>If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.</p> -->

                            <!-- <form class="form-horizontal" method="POST" action="{{-- route('disable2fa') --}}"> -->

                                {{ csrf_field() }}

                                <!-- <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">

                                    <label for="change-password" class="control-label">Current Password</label>

                                        <input id="current-password" type="password" class="form-control col-md-4" name="current-password" required>

                                        @if ($errors->has('current-password'))

                                            <span class="help-block">

                                        <strong>{{ $errors->first('current-password') }}</strong>

                                        </span>

                                        @endif

                                </div> -->

                                <!-- <button type="submit" class="btn btn-primary ">Disable 2FA</button> -->

                            <!-- </form> -->

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
             </div>

          </div>
       </div>
    </div>
</section>

@endsection