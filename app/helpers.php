<?php
// use Auth;
// use Hash;

/**
 check if two factor is enabled
*/
if ( !function_exists("twoFactorExists")) 
{
	function twoFactorExists($user_id = 0 )
	{
		if ($user_id == 0) {
			$user = Illuminate\Support\Facades\Auth::user();	
		}else {
			$user = App\User::find($user_id);
		}	 	
       
        if($user->loginSecurity()->exists()){
            return true;
        }

        return false;    
	}
}