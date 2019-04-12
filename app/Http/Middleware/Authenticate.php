<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

//defining a username and password
define('USERNAME','belalkhan');
define('PASSWORD', '123456');

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //getting values from headers
        //if the user is authenticated accepting the request
        if($request->header('PHP_AUTH_USER') == USERNAME && $request->header('PHP_AUTH_PW') == PASSWORD) {
            return $next($request);

            //else displaying an unauthorized message 
        } else {
            $content = array();
            $content['error'] = true; 
            $content['message'] = 'Unauthorized Request';
            return response()->json($content, 401);
        }

        /*
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
        */
    }
}
