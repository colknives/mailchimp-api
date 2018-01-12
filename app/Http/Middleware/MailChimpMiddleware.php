<?php

namespace App\Http\Middleware;

use Illuminate\Http\Response;
use Closure;

class MailChimpMiddleware
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

        // Check if the mail chimp url is defined
        if( env('MAILCHIMP_URL') == '' ){

            $response = [
                'status' => false,
                'message' => 'Please set the Mail Chimp API URL in the env file'
            ];

            return response()->json($response, Response::HTTP_OK);

        }

        // Check if the mail chimp api key is defined
        if( env('MAILCHIMP_API_KEY') == '' ){

            $response = [
                'status' => false,
                'message' => 'Please set the Mail Chimp API Key in the env file'
            ];

            return response()->json($response, Response::HTTP_OK);

        }


        return $next($request);
    }
}
