<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\User;
use Redirect;
/*use App\Models\MrCnMapping;
use Illuminate\Support\Facades\Crypt;*/

class Verification
{
  public function handle($request, Closure $next)
  {

    $user_id = Auth::user()->id;
    $user_record = user::select('email_verify_status','mobile_verify_status')->where('id',$user_id)->first();
    
    if(($user_record->email_verify_status != 1) && ($user_record->mobile_verify_status != 1)){

      return Redirect('verification');
    }
    return $next($request);
  }

}