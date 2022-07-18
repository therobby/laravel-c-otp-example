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

        if($validate['code'] == '111111'){
            $code = new OtpCodes();
            $code->code = $validate['code'];
            $code->expiresOn = Carbon::now()->addHour();
            $code->user_id = $request->user()->id;
            $code->save();
            $request->session()->put('otp_key', $validate['code']);
            return redirect('/dashboard');
        }

        return back()->withErrors([
            'code' => 'The provided code is invalid.',
        ]);
    }

    public function index() {
        return view('otp');
    }
}
