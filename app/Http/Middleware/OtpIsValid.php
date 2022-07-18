<?php

namespace App\Http\Middleware;

use App\Models\OtpCodes;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class OtpIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!$request->user()->hasOtpOn){
            return $next($request);
        }

        $otpKey = $request->session()->get('otp_key', false);

        $dbKey = OtpCodes::where([['code', $otpKey], ['user_id', $request->user()->id]])->first();

        if($dbKey && $dbKey->expiresOn > Carbon::now()){
            return $next($request);
        }

        return redirect('login/otp');
    }
}
