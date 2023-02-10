<?php
namespace Admin\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class authJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::toUser($request->header('token'));
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['error'=>true,'statuscode'=> 401,'message'=>'Token is invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['error'=>true,'statuscode'=>401,'message'=>'Token is expired']);
            }else{
                return response()->json(['error'=>true,'statuscode'=> 422,'message'=>'Something is wrong']);
            }
        }
        return $next($request);
    }
}
