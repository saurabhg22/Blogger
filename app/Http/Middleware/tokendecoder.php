<?php

namespace App\Http\Middleware;

use Closure;

class tokendecoder
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
        $token = $request->header('x-access-token');
        if ($token == null){
            $data = [ 'success' => false, 'msg' => 'No token provided.'];
            return response(json_encode( $data ), 200);
        }
        else{
            $decoded = base64_decode($token);
            $now = time();
            if(json_decode($decoded) == null){
                $data = [ 'success' => false, 'msg' => 'Invalid Token.'];
                return response(json_encode( $data ), 200);
            }
            $decoded = json_decode($decoded);
            if($decoded->secret != 'awsome key'){
                $data = [ 'success' => false, 'msg' => 'Invalid Token.'];
                return response(json_encode( $data ), 200);
            }
            else if($decoded->exp <= $now){
                $data = [ 'success' => false, 'msg' => 'Token Expired.'];
                return response(json_encode( $data ), 200);
            }
            else{
                $request['decodedtoken'] = $decoded;
                return $next($request);
            }
        }
    }
}
