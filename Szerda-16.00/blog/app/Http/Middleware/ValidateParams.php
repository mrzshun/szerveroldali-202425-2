<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // request uri paraméterek validációja
        $number = $request->route()->parameters['number'];
        $string = $request->route()->parameters['string'];

        $errors = [];
        if(!filter_var($number,FILTER_VALIDATE_INT)) {
            $errors['number'] = 'A $number-nek pozitív egész számnak kell lennie';
        }

        if(!is_string($string)) {
            $errors['string'] = 'A $string-nek pozitív egész számnak kell lennie';
        }
        if(!empty($errors)) {
            return response()->json($errors,418);
        }
        // hibaüzenet ha nem ok

        // különben:
        return $next($request);
    }
}
