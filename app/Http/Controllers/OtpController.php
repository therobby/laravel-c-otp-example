<?php

namespace App\Http\Controllers;

use App\Models\OtpCodes;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    /**
     * Validate OTP Code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function validateOtp(Request $request) {
        $validate = $request->validate([
            'code' => ['required']
        ]);


        $dbKey = OtpCodes::where([['code', $validate['code']], ['user_id', $request->user()->id]])->first();

        if($dbKey && $dbKey->expiresOn > Carbon::now()){
            $request->session()->put('otp_key', $validate['code']);
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'code' => 'The provided code is invalid.',
        ]);
    }

    public function index(Request $request) {
        $code = new OtpCodes();
        $code->code = '111111';
        $code->expiresOn = Carbon::now()->addHour();
        $code->user_id = $request->user()->id;
        $code->save();
        return view('otp');
    }
}
