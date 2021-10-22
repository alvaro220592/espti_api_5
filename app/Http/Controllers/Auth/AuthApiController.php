<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function refreshToken(Request $request){
        // Se a pessoa não tiver um token:
        if(! $token = $request->get('token'))
            return response()->json(['Erro' => 'Token não enviado'], 401);

        try {
            // Vai atualizar o token caso a pessoa tenha um
            $token = JWTAuth::refresh($token);
        } catch (TokenInvalidException $t) {
            // Se forum token inválido:
            return response()->json(
                [
                'Mensagem' => 'Token inválido',
                'Erro' => $t->getMessage()
                ]
            );
        }
        return response()->json([
            'Mensagem' => 'Token renovado com sucesso',
            compact('token')
            ]);
    }
}
