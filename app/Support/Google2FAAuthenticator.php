<?php

namespace App\Support;

use PragmaRX\Google2FALaravel\Support\Authenticator;
use Session;
class Google2FAAuthenticator extends Authenticator
{
    protected function canPassWithoutCheckingOTP()
    {
        // dd($this->getUser()->loginSecurity->google2fa_secret);
        // dd( $this->getUser()->loginSecurity->google2fa_enable;
        // dd(Session::get('ahmad'));
        if($this->getUser()->loginSecurity == null)
           {
            return true;
           }
        
        // return false;
           if(!$this->getUser()->loginSecurity->google2fa_enable){return true;}
        //     !$this->getUser()->loginSecurity->google2fa_enable ||
        //     !$this->isEnabled() ||
        //     $this->noUserIsAuthenticated() ||
        //     $this->twoFactorAuthStillValid();
           if(Session::get('ahmad') == 1){
            return true;
           }
           else{
            return false;
           }
    }

    protected function getGoogle2FASecretKey()
    {
        $secret = $this->getUser()->loginSecurity->{$this->config('otp_secret_column')};
        // dd($secret);
        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty.');
        }

        return $secret;
    }

}