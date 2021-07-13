<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use phpseclib\Crypt\Hash;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends AccessTokenController
{
    public function auth(ServerRequestInterface $request)
    {

        $tokenResponse = parent::issueToken($request);
        //return response('test',422);
        $token = $tokenResponse->getContent();

        // $tokenInfo will contain the usual Laravel Passort token response.
        $tokenInfo = json_decode($token, true);

        // Then we just add the user to the response before returning it.
        $username = $request->getParsedBody()['username'];

        $user = User::with(['role' => function ($data) {
            return $data->with(['permissions']);
        }])->whereEmail($username)->first();
        $tokenInfo = collect($tokenInfo);
        $tokenInfo->put('user', $user);


        if (isset($tokenInfo['error']) && $tokenInfo['error'] == 'invalid_credentials')
            return response('Incorrect Username or Password!', 404);

        return response($tokenInfo);
    }

    public function get(Request $request)
    {
        return response(
            [
                'user' => User::with(['role' => function ($data) {
                    return $data->with(['role_permissions']);
                }])->find(Auth::id())
            ]
        );
    }
    public function all()
    {
        return response(User::where('id','!=',Auth::id())->get());
    }
}
