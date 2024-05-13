<?php

namespace App\Service;


use Illuminate\Support\Facades\Session;

class hcaptcha
{
    public function check($captcha)
    {
        $data = array(
            'secret' => "",
            'response' => $captcha
        );
        $verify = curl_init();
        curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($verify, CURLOPT_POST, true);
        curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($verify);
// var_dump($response);
        $responseData = json_decode($response);
        if ($responseData->success) {
            return true;
        } else {
            Session::flash('alert-danger', 'captcha error');
            return false;
        }

    }
}

