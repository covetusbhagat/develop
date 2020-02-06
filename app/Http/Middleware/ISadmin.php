<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class ISadmin
{

   public function handle($request, Closure $next)
   {
        if (Session::get('role_id') !== 1)
        {
             echo "You are not able to do this Opration";
           die();
           /*return redirect('home');*/
        }
       return $next($request);

   }

}