<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function sendsms()
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $sendernumber = getenv("TWILIO_FROM");
        $twilio = new Client($sid, $token);
        $otp = rand(10000, 99999);

        $message = $twilio->messages
            ->create(
                "+92 310 9704986", // to
                [
                    "body" => "Your OTP is $otp",
                    "from" => $sendernumber
                ]
            );
        dd('measage send succesfully');
    }
}